<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Appointment;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        $doctorCount = Doctor::count();
        $specialtyCount = Specialty::count();
        $appointmentCount = Appointment::count();
        
        // Get all specialties for the appointment form
        $specialties = Specialty::all();
        
        // Get featured specialties for the carousel (limit to 5)
        $featuredSpecialties = Specialty::take(5)->get();
        
        // Get featured doctors (limit to 8)
        $doctors = Doctor::with('specialty')
            ->take(8)
            ->get();

        return view('frontend.home', compact(
            'doctorCount',
            'specialtyCount',
            'appointmentCount',
            'specialties',
            'featuredSpecialties',
            'doctors'
        ));
    }

    public function about()
    {
        $doctors = Doctor::with('specialty')->where('is_active', true)->take(4)->get();
        return view('frontend.about', compact('doctors'));
    }
}
