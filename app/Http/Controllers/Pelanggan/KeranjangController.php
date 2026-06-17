<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Rental;
use App\Models\RentalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // Lihat keranjang
    public function index()
    {
        $keranjang = session('keranjang', []);
        return view('pelanggan.keranjang', compact('keranjang'));
    }

    // Tambah ke keranjang
    public function store(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);
        
        // Cek status
        if ($equipment->status != 'available') {
            return back()->with('error', 'Alat tidak tersedia!');
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'tgl_mulai' => 'required|date|after_or_equal:today',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
        ]);
        
        // Cek stok
        if ($request->quantity > $equipment->stock) {
            return back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $equipment->stock);
        }
        
        $tgl_mulai = new \DateTime($request->tgl_mulai);
        $tgl_selesai = new \DateTime($request->tgl_selesai);
        $lama_sewa = $tgl_mulai->diff($tgl_selesai)->days;
        if ($lama_sewa < 1) $lama_sewa = 1;
        
        $subtotal = $lama_sewa * $equipment->price_per_day * $request->quantity;
        
        $keranjang = session('keranjang', []);
        
        // Cek apakah sudah ada di keranjang (alat sama + tanggal sama = gabung)
        $found = false;
        foreach ($keranjang as $key => $item) {
            if ($item['equipment_id'] == $id 
                && $item['tgl_mulai'] == $request->tgl_mulai 
                && $item['tgl_selesai'] == $request->tgl_selesai) {
                
                // Cek stok untuk quantity gabungan
                $new_quantity = $keranjang[$key]['quantity'] + $request->quantity;
                if ($new_quantity > $equipment->stock) {
                    return back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $equipment->stock . ', sudah di keranjang: ' . $keranjang[$key]['quantity']);
                }
                $keranjang[$key]['quantity'] = $new_quantity;
                $keranjang[$key]['subtotal'] += $subtotal;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $keranjang[] = [
                'equipment_id' => $equipment->equipment_id,
                'name' => $equipment->name,
                'price_per_day' => $equipment->price_per_day,
                'quantity' => $request->quantity,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'lama_sewa' => $lama_sewa,
                'subtotal' => $subtotal,
                'image_url' => $equipment->image_url,
                'metode' => $request->metode,
                'alamat' => $request->alamat ?? null,
                'toko' => $request->toko ?? null,
            ];
        }
        
        session(['keranjang' => $keranjang]);
        
        return redirect()->route('pelanggan.keranjang')->with('success', 'Alat berhasil ditambahkan ke keranjang!');
    }

    // Hapus item keranjang
    public function destroy($index)
    {
        $keranjang = session('keranjang', []);
        
        if (isset($keranjang[$index])) {
            unset($keranjang[$index]);
            session(['keranjang' => array_values($keranjang)]);
        }
        
        return redirect()->route('pelanggan.keranjang')->with('success', 'Item berhasil dihapus!');
    }

    // Checkout - 1 item keranjang = 1 rental
    public function checkout()
    {
        $keranjang = session('keranjang', []);
        
        if (empty($keranjang)) {
            return redirect()->route('pelanggan.keranjang')->with('error', 'Keranjang kosong!');
        }
        
        // Cek ulang stok sebelum checkout
        foreach ($keranjang as $item) {
            $equipment = Equipment::find($item['equipment_id']);
            if ($item['quantity'] > $equipment->stock) {
                return redirect()->route('pelanggan.keranjang')->with('error', 'Stok ' . $equipment->name . ' tidak mencukupi! Stok tersedia: ' . $equipment->stock);
            }
        }
        
        // Setiap item di keranjang jadi 1 rental (tidak digabung)
        foreach ($keranjang as $item) {
            $rental = Rental::create([
                'user_id' => Auth::id(),
                'rental_date' => $item['tgl_mulai'],
                'return_date_expected' => $item['tgl_selesai'],
                'total_price' => $item['subtotal'],
                'status_payment' => 'pending',
                'metode_pengambilan' => $item['metode'] ?? 'toko',
                'alamat' => $item['alamat'] ?? null,
                'toko_tujuan' => $item['toko'] ?? null,
            ]);
            
            RentalItem::create([
                'rental_id' => $rental->rental_id,
                'equipment_id' => $item['equipment_id'],
                'quantity' => $item['quantity'],
            ]);
            
            // Kurangi stok
            $equipment = Equipment::find($item['equipment_id']);
            $equipment->stock -= $item['quantity'];
            if ($equipment->stock <= 0) {
                $equipment->status = 'rented';
            }
            $equipment->save();
        }
        
        // Kosongkan keranjang
        session()->forget('keranjang');
        
        return redirect()->route('pelanggan.riwayat')->with('success', 'Peminjaman berhasil! Silakan lakukan pembayaran.');
    }
}