<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display the about page.
     */
    public function index(): View
    {
        $doctors = Doctor::with('specialty')
            ->take(4)
            ->get();
            
        return view('frontend.about', compact('doctors'));
    }
} 