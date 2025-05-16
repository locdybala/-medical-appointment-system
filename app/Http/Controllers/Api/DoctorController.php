<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with(['user', 'specialty', 'room'])
            ->where('is_active', true);

        // Lọc theo chuyên khoa
        if ($request->has('specialty_id')) {
            $query->where('specialty_id', $request->specialty_id);
        }

        // Lọc theo phòng khám
        if ($request->has('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        $doctors = $query->get()->map(function ($doctor) {
            return [
                'id' => $doctor->id,
                'name' => $doctor->user->name,
                'specialty' => $doctor->specialty->name,
                'room' => $doctor->room ? $doctor->room->name : null,
                'consultation_fee' => $doctor->consultation_fee,
                'experience' => $doctor->experience,
                'qualification' => $doctor->qualification
            ];
        });

        return response()->json([
            'doctors' => $doctors
        ]);
    }
} 