<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::with('doctor')->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::where('is_active', true)->get();
        return view('admin.schedules.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after:today',
            'shift' => 'required|in:morning,afternoon',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_patients' => 'required|integer|min:1',
            'is_available' => 'boolean'
        ]);

        Schedule::create([
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'shift' => $request->shift,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_patients' => $request->max_patients,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Lịch khám đã được thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $doctors = Doctor::where('is_active', true)->get();
        return view('admin.schedules.edit', compact('schedule', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after:today',
            'shift' => 'required|in:morning,afternoon',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_patients' => 'required|integer|min:1',
            'is_available' => 'boolean'
        ]);

        $schedule->update([
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'shift' => $request->shift,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_patients' => $request->max_patients,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Thông tin lịch khám đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        if ($schedule->appointments()->count() > 0) {
            return redirect()->route('admin.schedules.index')
                ->with('error', 'Không thể xóa lịch khám này vì đang có lịch hẹn.');
        }

        $schedule->delete();
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Lịch khám đã được xóa thành công.');
    }
}
