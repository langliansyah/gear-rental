<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('rentals')
            ->where('role', 'pelanggan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.user.index', compact('users'));
    }

    public function destroy($id)
    {
        if ($id == Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        User::destroy($id);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }
}