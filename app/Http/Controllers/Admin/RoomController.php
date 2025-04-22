<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'floor' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        Room::create([
            'name' => $request->name,
            'description' => $request->description,
            'floor' => $request->floor,
            'capacity' => $request->capacity,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Phòng khám đã được thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'floor' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $room->update([
            'name' => $request->name,
            'description' => $request->description,
            'floor' => $request->floor,
            'capacity' => $request->capacity,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Thông tin phòng khám đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        if ($room->doctors()->count() > 0) {
            return redirect()->route('admin.rooms.index')
                ->with('error', 'Không thể xóa phòng khám này vì đang có bác sĩ được phân công.');
        }

        $room->delete();
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Phòng khám đã được xóa thành công.');
    }
}
