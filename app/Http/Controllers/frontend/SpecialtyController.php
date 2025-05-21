<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Room;

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

    /**
     * Lấy danh sách phòng khám theo chuyên khoa
     */
    public function getRooms(Specialty $specialty)
    {
        try {
            // Lấy danh sách phòng khám có bác sĩ thuộc chuyên khoa này
            $rooms = Room::whereHas('doctors', function($query) use ($specialty) {
                $query->where('specialty_id', $specialty->id);
            })->get();

            return response()->json([
                'success' => true,
                'data' => $rooms
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy danh sách phòng khám'
            ], 500);
        }
    }
}
