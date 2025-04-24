<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     */
    public function index(): View
    {
        $appointments = auth('patient')->user()
            ->appointments()
            ->with(['doctor.specialty'])
            ->latest()
            ->paginate(10);

        return view('frontend.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create(Request $request): View
    {
        $specialties = Specialty::where('is_active', true)->get();
        $doctor = null;

        if ($request->has('doctor')) {
            $doctor = Doctor::with('specialty', 'user')
                ->where('id', $request->doctor)
                ->where('is_active', true)
                ->first();
        }

        return view('frontend.appointments.create', compact('specialties', 'doctor'));
    }

    public function getDoctorsBySpecialty(Specialty $specialty)
    {
        $doctors = $specialty->doctors()
            ->with(['user', 'specialty'])
            ->where('is_active', true)
            ->get()
            ->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->user->name,
                    'specialty' => $doctor->specialty->name,
                    'experience' => $doctor->experience,
                    'consultation_fee' => $doctor->consultation_fee,
                ];
            });

        return response()->json($doctors);
    }

    public function getAvailableSlots(Request $request, Doctor $doctor)
    {
        try {
            $request->validate([
                'date' => 'required|date'
            ]);

            $date = Carbon::parse($request->date);

            // Kiểm tra ngày có hợp lệ không (không phải ngày quá khứ)
            if ($date->lt(Carbon::today())) {
                return response()->json([
                    'error' => 'Không thể đặt lịch cho ngày trong quá khứ'
                ], 400);
            }

            // Giờ làm việc cố định: 8h - 17h
            $startTime = Carbon::parse('08:00:00');
            $endTime = Carbon::parse('17:00:00');

            // Tạo danh sách các slot 1 tiếng
            $slots = [];
            $currentTime = $startTime->copy();

            while ($currentTime->lt($endTime)) {
                $slotEnd = $currentTime->copy()->addHour();

                // Kiểm tra xem slot này có bị trùng không
                $isBooked = Appointment::where('doctor_id', $doctor->id)
                    ->whereDate('appointment_date', $date)
                    ->whereTime('appointment_time', '>=', $currentTime->format('H:i:s'))
                    ->whereTime('appointment_time', '<', $slotEnd->format('H:i:s'))
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->exists();

                if (!$isBooked) {
                    $slots[] = $currentTime->format('H:i');
                }

                $currentTime->addHour();
            }

            return response()->json($slots);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in getAvailableSlots: ' . json_encode($e->errors()));
            return response()->json([
                'error' => 'Dữ liệu không hợp lệ: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in getAvailableSlots: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Có lỗi xảy ra khi lấy danh sách giờ khám: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required',
                'symptoms' => 'required|string|max:500',
            ]);

            $date = Carbon::parse($validated['appointment_date']);
            $doctor = Doctor::findOrFail($validated['doctor_id']);

            // Kiểm tra xem slot giờ có trống không
            $existingAppointment = Appointment::where('doctor_id', $validated['doctor_id'])
                ->whereDate('appointment_date', $date)
                ->whereTime('appointment_time', $validated['appointment_time'])
                ->whereIn('status', ['pending', 'confirmed'])
                ->first();

            if ($existingAppointment) {
                return back()->withErrors(['appointment_time' => 'Giờ này đã được đặt']);
            }

            // Tạo lịch hẹn mới
            $appointment = Appointment::create([
                'patient_id' => auth()->id(),
                'doctor_id' => $validated['doctor_id'],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'symptoms' => $validated['symptoms'],
                'status' => 'pending',
                'fee' => $doctor->consultation_fee ?? 0,
                'is_paid' => false,
                'reason' => null,
                'notes' => null,
                'prescription' => null,
                'diagnosis' => null
            ]);

            return redirect()->route('appointments.index')
                ->with('success', 'Đặt lịch hẹn thành công! Vui lòng chờ xác nhận từ bác sĩ.');

        } catch (\Exception $e) {
            \Log::error('Error creating appointment: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment): View
    {
        $this->authorize('view', $appointment);
        return view('frontend.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment): View
    {
        $this->authorize('update', $appointment);

        $specialties = Specialty::all();
        return view('frontend.appointments.edit', compact('appointment', 'specialties'));
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after:today',
            'symptoms' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Cập nhật lịch khám thành công!');
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        try {
            $appointment->delete();
            return redirect()->route('appointments.index')
                ->with('success', 'Đã hủy lịch hẹn thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi hủy lịch hẹn');
        }
    }

    public function history(): View
    {
        $appointments = auth('patient')->user()
            ->appointments()
            ->with(['doctor.specialty'])
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        return view('frontend.appointments.history', compact('appointments'));
    }
}
