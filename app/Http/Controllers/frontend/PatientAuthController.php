<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $patient = Patient::where('email', $credentials['email'])->first();

        if ($patient && Hash::check($credentials['password'], $patient->password)) {
            Auth::guard('patient')->login($patient);
            return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Đăng xuất thành công.');
    }

    public function showRegistrationForm()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
        ]);

        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'is_active' => true,
        ]);

        Auth::guard('patient')->login($patient);

        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }

    public function profile()
    {
        return view('frontend.auth.profile', [
            'patient' => auth()->guard('patient')->user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $patient = auth()->guard('patient')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
        ]);

        $patient->update($request->only([
            'name', 'phone', 'address', 'date_of_birth', 'gender'
        ]));

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
