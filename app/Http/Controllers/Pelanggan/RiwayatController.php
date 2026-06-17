<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['rentalItems.equipment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('pelanggan.riwayat', compact('rentals'));
    }
}