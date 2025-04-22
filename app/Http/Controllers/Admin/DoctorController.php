<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Room;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['specialty', 'room', 'user'])->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $specialties = Specialty::where('is_active', true)->get();
        $rooms = Room::where('is_active', true)->get();
        return view('admin.doctors.create', compact('specialties', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'specialty_id' => 'required|exists:specialties,id',
            'room_id' => 'required|exists:rooms,id',
            'is_active' => 'boolean'
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make('password123'), // Default password
        ]);

        // Assign doctor role
        $doctorRole = Role::where('slug', 'doctor')->first();
        $user->assignRole($doctorRole);

        // Create doctor profile
        $doctor = Doctor::create([
            'user_id' => $user->id,
            'specialty_id' => $request->specialty_id,
            'room_id' => $request->room_id,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Bác sĩ đã được thêm thành công.');
    }

    public function edit(Doctor $doctor)
    {
        $specialties = Specialty::where('is_active', true)->get();
        $rooms = Room::where('is_active', true)->get();
        return view('admin.doctors.edit', compact('doctor', 'specialties', 'rooms'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'phone' => 'required|string|max:20',
            'specialty_id' => 'required|exists:specialties,id',
            'room_id' => 'required|exists:rooms,id',
            'is_active' => 'boolean'
        ]);

        // Update user account
        $doctor->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Update doctor profile
        $doctor->update([
            'specialty_id' => $request->specialty_id,
            'room_id' => $request->room_id,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Thông tin bác sĩ đã được cập nhật.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('admin.doctors.index')
            ->with('success', 'Bác sĩ đã được xóa.');
    }
} 