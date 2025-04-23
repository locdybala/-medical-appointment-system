<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentHistoryController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['doctor.user', 'doctor.specialty'])
            ->where('patient_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('frontend.appointments.history', compact('appointments'));
    }
} 