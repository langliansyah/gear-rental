<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'Username tidak terdaftar!')->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah!')->withInput();
        }

        Auth::login($user);

        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('pelanggan.dashboard');
    }

    // Halaman Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'full_name' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}