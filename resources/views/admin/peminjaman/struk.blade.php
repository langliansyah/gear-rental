<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Peminjaman #{{ $rental->rental_id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; font-size: 13px; padding: 20px; background: #f5f5f5; }
        .struk { max-width: 400px; margin: 0 auto; background: #fff; border-radius: 10px; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px dashed #E4E4E4; padding-bottom: 15px; }
        .header h2 { font-weight: 800; font-size: 18px; margin-bottom: 5px; color: #E9663C; }
        .header p { font-size: 11px; color: #555; }
        .row { display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 12px; }
        .row .label { font-weight: bold; color: #333; }
        .divider { border-top: 1px dashed #E4E4E4; margin: 12px 0; }
        .items { margin-bottom: 10px; }
        .items table { width: 100%; border-collapse: collapse; }
        .items th { text-align: left; font-size: 11px; border-bottom: 1px solid #E4E4E4; padding: 4px 0; }
        .items td { font-size: 12px; padding: 4px 0; }
        .total { font-size: 16px; font-weight: bold; text-align: right; margin-top: 12px; color: #E9663C; }
        .footer { text-align: center; margin-top: 20px; font-size: 11px; border-top: 2px dashed #E4E4E4; padding-top: 15px; color: #555; }
        .alamat-box { background: #f9f9f9; padding: 8px 10px; margin: 8px 0; border-radius: 5px; font-size: 11px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .badge-lunas { background: #1D9E75; color: #fff; }
        .badge-pending { background: #FFB61D; color: #000; }
        .badge-cancel { background: #DC3545; color: #fff; }
        @media print {
            body { background: #fff; padding: 0; }
            .struk { box-shadow: none; border-radius: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <button class="no-print" onclick="window.print()" style="margin-bottom: 15px; padding: 10px 25px; cursor: pointer; display: block; margin-left: auto; margin-right: auto; background: #E9663C; color: #fff; border: none; border-radius: 50px; font-weight: bold;">
        🖨️ Cetak Struk
    </button>

    <div class="struk">
        <div class="header">
            <h2>GEAR RENTAL</h2>
            <p>Sistem Peminjaman Peralatan Pendakian</p>
            <p>Jl. Raya Pendakian No.1, Indonesia</p>
        </div>

        <div class="row">
            <span class="label">No. Transaksi</span>
            <span>#{{ str_pad($rental->rental_id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="row">
            <span class="label">Tanggal</span>
            <span>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y') }}</span>
        </div>
        <div class="row">
            <span class="label">Pelanggan</span>
            <span>{{ $rental->user->full_name }}</span>
        </div>

        <div class="divider"></div>

        <div class="row">
            <span class="label">Metode</span>
            <span>
                @if($rental->metode_pengambilan == 'cod')
                    <span class="badge badge-pending">COD</span>
                @else
                    <span class="badge badge-lunas">Ambil ke Toko</span>
                @endif
            </span>
        </div>

        @if($rental->metode_pengambilan == 'cod')
            <div class="alamat-box">
                <strong>Alamat Pengiriman:</strong><br>
                {{ $rental->alamat ?? 'Alamat tidak dicantumkan' }}
            </div>
        @else
            <div class="alamat-box">
                <strong>Toko Tujuan:</strong><br>
                {{ $rental->toko_tujuan ?? 'Toko tidak dipilih' }}
            </div>
        @endif

        <div class="divider"></div>

        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rental->rentalItems as $item)
                        <tr>
                            <td>{{ $item->equipment->name ?? '-' }}</td>
                            <td>{{ $item->quantity }}x</td>
                            <td>Rp {{ number_format(($item->equipment->price_per_day ?? 0) * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="divider"></div>

        <div class="row">
            <span class="label">Tgl Pinjam</span>
            <span>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y') }}</span>
        </div>
        <div class="row">
            <span class="label">Tgl Kembali</span>
            <span>{{ \Carbon\Carbon::parse($rental->return_date_expected)->format('d/m/Y') }}</span>
        </div>
        <div class="row">
            <span class="label">Lama Sewa</span>
            <span>{{ \Carbon\Carbon::parse($rental->rental_date)->diffInDays(\Carbon\Carbon::parse($rental->return_date_expected)) }} hari</span>
        </div>

        <div class="total">
            TOTAL: Rp {{ number_format($rental->total_price, 0, ',', '.') }}
        </div>

        <div class="footer">
            <p>
                Status: 
                @if($rental->status_payment == 'paid')
                    <span class="badge badge-lunas">LUNAS</span>
                @elseif($rental->status_payment == 'pending')
                    <span class="badge badge-pending">PENDING</span>
                @else
                    <span class="badge badge-cancel">DIBATALKAN</span>
                @endif
            </p>
            <p>Terima kasih telah menggunakan jasa kami!</p>
        </div>
    </div>
</body>
</html>