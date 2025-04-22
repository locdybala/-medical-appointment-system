<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();
        return view('admin.specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('admin.specialties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        Specialty::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.specialties.index')
            ->with('success', 'Chuyên khoa đã được thêm thành công.');
    }

    public function edit(Specialty $specialty)
    {
        return view('admin.specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $specialty->update([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.specialties.index')
            ->with('success', 'Thông tin chuyên khoa đã được cập nhật thành công.');
    }

    public function destroy(Specialty $specialty)
    {
        if ($specialty->doctors()->count() > 0) {
            return redirect()->route('admin.specialties.index')
                ->with('error', 'Không thể xóa chuyên khoa này vì đang có bác sĩ thuộc chuyên khoa.');
        }

        $specialty->delete();
        return redirect()->route('admin.specialties.index')
            ->with('success', 'Chuyên khoa đã được xóa thành công.');
    }
} 