<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Rental;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with(['user', 'rentalItems.equipment']);

        if ($request->status) {
            $query->where('status_payment', $request->status);
        }

        $rentals = $query->orderBy('created_at', 'desc')->get();

        return view('admin.peminjaman.index', compact('rentals'));
    }

    public function konfirmasi($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->status_payment = 'paid';
        $rental->save();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    public function batalkan($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->status_payment = 'cancelled';
        $rental->save();

        // Kembalikan stok & status alat
        foreach ($rental->rentalItems as $item) {
            $eq = Equipment::find($item->equipment_id);
            if ($eq) {
                $eq->stock += $item->quantity;
                if ($eq->stock > 0 && $eq->status == 'rented') {
                    $eq->status = 'available';
                }
                $eq->save();
            }
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dibatalkan!');
    }

    public function cetakStruk($id)
    {
        $rental = Rental::with(['user', 'rentalItems.equipment'])->findOrFail($id);
        return view('admin.peminjaman.struk', compact('rental'));
    }
}