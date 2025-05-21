<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Lấy danh sách bác sĩ theo phòng khám
     */
    public function getDoctors(Room $room)
    {
        try {
            $doctors = $room->doctors()
                ->with(['user', 'specialty'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $doctors
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy danh sách bác sĩ'
            ], 500);
        }
    }
} 