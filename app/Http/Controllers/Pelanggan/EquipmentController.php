<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    // Katalog peralatan
    public function index(Request $request)
    {
        $categories = Category::orderBy('category_name')->get();
        
        $query = Equipment::with('category');
        
        // Filter kategori
        if ($request->kategori) {
            $query->where('category_id', $request->kategori);
        }
        
        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['available', 'rented']);
        }
        
        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $equipments = $query->orderBy('name')->get();
        
        return view('pelanggan.katalog', compact('equipments', 'categories'));
    }

    // Detail alat
    public function show($id)
    {
        $equipment = Equipment::with('category')->findOrFail($id);
        return view('pelanggan.detail', compact('equipment'));
    }
}