<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::where('is_active', true)
            ->withCount('doctors')
            ->paginate(12);
        
        return view('frontend.specialties.index', compact('specialties'));
    }

    public function show(Specialty $specialty)
    {
        $doctors = $specialty->doctors()
            ->where('is_active', true)
            ->paginate(9);
            
        return view('frontend.specialties.show', compact('specialty', 'doctors'));
    }
}
