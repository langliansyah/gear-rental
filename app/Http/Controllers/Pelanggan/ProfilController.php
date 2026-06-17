<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pelanggan.profil', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('pelanggan.edit_profil', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->full_name = $request->full_name;
        $user->save();

        return redirect()->route('pelanggan.profil')->with('success', 'Profil berhasil diupdate!');
    }

    public function showPasswordForm()
    {
        return view('pelanggan.ganti_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect()->route('pelanggan.profil')->with('success', 'Password berhasil diubah!');
    }
}