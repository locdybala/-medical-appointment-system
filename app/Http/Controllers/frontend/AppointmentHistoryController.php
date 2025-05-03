<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AppointmentHistoryController extends Controller
{
    public function index(): View
    {
        $appointments = auth('patient')->user()
            ->appointments()
            ->with(['doctor.specialty', 'doctor.user'])
            ->latest()
            ->paginate(10);

        return view('frontend.appointments.history', compact('appointments'));
    }
}
