<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'schedule'])
            ->latest()
            ->get();
            
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();
        $schedules = Schedule::where('is_active', true)->get();
        
        return view('admin.appointments.create', compact('patients', 'doctors', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'schedule_id' => $request->schedule_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'status' => 'approved',
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Lịch hẹn đã được tạo thành công.');
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();
        $schedules = Schedule::where('is_active', true)->get();
        
        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors', 'schedules'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,approved,rejected,completed,cancelled,no_show',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'prescription' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'fee' => 'nullable|numeric|min:0',
            'is_paid' => 'boolean',
        ]);

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'schedule_id' => $request->schedule_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'prescription' => $request->prescription,
            'diagnosis' => $request->diagnosis,
            'fee' => $request->fee,
            'is_paid' => $request->is_paid ?? false,
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Lịch hẹn đã được cập nhật thành công.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        
        return redirect()->route('admin.appointments.index')
            ->with('success', 'Lịch hẹn đã được xóa thành công.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed,cancelled,no_show',
        ]);

        $appointment->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Trạng thái lịch hẹn đã được cập nhật thành công.');
    }
} 