<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Specialty;
use Illuminate\View\View;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $rooms = Room::where('is_active', true)->get();
        $doctor = null;

        if ($request->has('doctor')) {
            $doctor = Doctor::with('specialty', 'user')
                ->where('id', $request->doctor)
                ->where('is_active', true)
                ->first();
        }

        return view('frontend.appointments.create', compact('specialties', 'rooms', 'doctor'));
    }

    public function getDoctorsBySpecialty(Specialty $specialty)
    {
        $doctors = $specialty->doctors()
            ->with(['user', 'specialty'])
            ->where('is_active', true)
            ->get();

        $formattedDoctors = $doctors->map(function ($doctor) {
            return [
                'id' => $doctor->id,
                'user' => [
                    'name' => $doctor->user->name
                ],
                'specialty' => [
                    'name' => $doctor->specialty->name
                ],
                'experience' => $doctor->experience,
                'consultation_fee' => $doctor->consultation_fee
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedDoctors
        ]);
    }

    public function getAvailableSlots(Request $request, Doctor $doctor)
    {
        try {
            $date = Carbon::parse($request->date);

            // Kiểm tra ngày trong quá khứ
            if ($date->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể đặt lịch cho ngày trong quá khứ'
                ]);
            }

            // Giờ làm việc mặc định: 8h - 17h
            $startTime = '08:00';
            $endTime = '17:00';
            $duration = 60; // 1 tiếng

            // Tạo các slot thời gian từ giờ bắt đầu đến giờ kết thúc
            $slots = $this->generateTimeSlots($startTime, $endTime, $duration);

            if (empty($slots)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có giờ khám nào được cấu hình'
                ]);
            }

            // Lấy danh sách các slot đã được đặt
            $bookedAppointments = Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', $date)
                ->whereIn('status', ['pending', 'confirmed'])
                ->pluck('appointment_time')
                ->map(function($time) {
                    return Carbon::parse($time)->format('H:i');
                })
                ->toArray();

            // Lọc bỏ các slot đã được đặt
            $availableSlots = array_values(array_diff($slots, $bookedAppointments));

            // Nếu đã qua giờ hiện tại, loại bỏ các slot đã qua
            if ($date->isToday()) {
                $now = Carbon::now();
                $availableSlots = array_filter($availableSlots, function($slot) use ($now) {
                    return Carbon::parse($slot)->gt($now);
                });
            }

            if (empty($availableSlots)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không còn giờ khám nào trong ngày này'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => array_values($availableSlots)
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getAvailableSlots: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy danh sách giờ khám'
            ]);
        }
    }

    private function generateTimeSlots($startTime, $endTime, $duration)
    {
        try {
            $slots = [];
            $start = Carbon::parse($startTime);
            $end = Carbon::parse($endTime);

            while ($start < $end) {
                $slots[] = $start->format('H:i');
                $start->addMinutes($duration);
            }

            return $slots;
        } catch (\Exception $e) {
            \Log::error('Error generating time slots: ' . $e->getMessage());
            return [];
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
