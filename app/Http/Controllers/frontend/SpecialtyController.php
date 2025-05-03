<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\Doctor;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::where('is_active', true)
            ->withCount('doctors')
            ->paginate(12);

        return view('frontend.specialties.index', compact('specialties'));
    }

    public function show($id)
    {
        $specialty = Specialty::find($id);
        $doctors = Doctor::where('specialty_id', '=', $specialty->id)->paginate(9);

        return view('frontend.specialties.show', compact('specialty', 'doctors'));
    }
}
