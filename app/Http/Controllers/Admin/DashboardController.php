<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Rental;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $available = Equipment::where('status', 'available')->count();
        $rented = Equipment::where('status', 'rented')->count();
        $maintenance = Equipment::where('status', 'maintenance')->count();
        $pending = Rental::where('status_payment', 'pending')->count();
        $paid = Rental::where('status_payment', 'paid')->count();
        $total_user = User::where('role', 'pelanggan')->count();

        return view('admin.dashboard', compact(
            'available', 'rented', 'maintenance', 'pending', 'paid', 'total_user'
        ));
    }
}