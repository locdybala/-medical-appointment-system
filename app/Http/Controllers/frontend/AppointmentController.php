<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     */
    public function index(): View
    {
        $appointments = auth()->user()
            ->appointments()
            ->with(['doctor.specialty'])
            ->latest()
            ->paginate(10);

        return view('frontend.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create(): View
    {
        $specialties = Specialty::all();
        $doctors = Doctor::with('user', 'specialty')->where('is_active', true)->get();

        return view('frontend.appointments.create', [
            'specialties' => $specialties,
            'doctors' => $doctors
        ]);
    }

    public function getDoctorsBySpecialty($specialtyId)
    {
        $doctors = Doctor::with('user')
            ->where('specialty_id', $specialtyId)
            ->where('is_active', true)
            ->get();

        return response()->json($doctors);
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'symptoms' => 'required|string',
        ]);

        $appointment = Appointment::create([
            'patient_id' => auth()->guard('patient')->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'symptoms' => $request->symptoms,
            'status' => 'pending',
            'fee' => 0, // Sẽ được cập nhật bởi admin/bác sĩ
        ]);

        return redirect()->route('appointments.history')
            ->with('success', 'Đặt lịch khám thành công! Vui lòng chờ xác nhận từ phòng khám.');
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

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Hủy lịch khám thành công!');
    }
}
