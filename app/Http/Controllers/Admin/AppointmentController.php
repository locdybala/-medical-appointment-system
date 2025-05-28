<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor.user'])->latest()->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'fee' => 'required|numeric|min:0',
            'is_paid' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        Appointment::create($request->all());

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Lịch hẹn đã được tạo thành công.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.user']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        // Nếu chỉ gửi status (bác sĩ xác nhận)
        if ($request->has('status') && count($request->all()) <= 4) {
            $request->validate([
                'status' => 'required|in:pending,confirmed,cancelled',
            ]);
            $appointment->update(['status' => $request->status]);
            $user = auth()->user();
            if ($user && $user->isDoctor()) {
                return redirect()->route('admin.my-appointments')->with('success', 'Lịch hẹn đã được xác nhận.');
            }
            return back()->with('success', 'Lịch hẹn đã được xác nhận.');
        }

        // Còn lại là update đầy đủ (admin)
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'fee' => 'required|numeric|min:0',
            'is_paid' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($request->all());
        $user = auth()->user();
        if ($user && $user->isDoctor()) {
            return redirect()->route('admin.my-appointments')->with('success', 'Lịch hẹn đã được cập nhật thành công.');
        }
        return redirect()->route('admin.appointments.index')
            ->with('success', 'Lịch hẹn đã được cập nhật thành công.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        $user = auth()->user();
        if ($user && $user->isDoctor()) {
            return redirect()->route('admin.my-appointments')->with('success', 'Lịch hẹn đã được xóa thành công.');
        }
        return redirect()->route('admin.appointments.index')
            ->with('success', 'Lịch hẹn đã được xóa thành công.');
    }

    public function myAppointments()
    {
        $user = auth()->user();
        $doctor = $user->doctor;
        
        if (!$doctor) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Không tìm thấy thông tin bác sĩ.');
        }

        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('doctor_id', $doctor->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return view('admin.appointments.my-appointments', compact('appointments'));
    }
}
