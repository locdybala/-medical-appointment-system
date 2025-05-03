<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('specialty')
            ->where('is_active', true)
            ->paginate(12);

        $specialties = Specialty::where('is_active', true)->get();

        return view('frontend.doctors.index', compact('doctors', 'specialties'));
    }

    public function show($id)
    {
        $doctor = Doctor::find($id);
        $doctor->load('specialty', 'room');
        return view('frontend.doctors.show', compact('doctor'));
    }
}
