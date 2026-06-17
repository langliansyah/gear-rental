<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\RentalItem;
use Illuminate\Http\Request;

class PeralatanController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with('category')->orderBy('name')->get();
        return view('admin.peralatan.index', compact('equipments'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        return view('admin.peralatan.tambah', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price_per_day' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image_url = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '_' . rand(1000, 9999) . '.' . $image->extension();
            $image->move(public_path('uploads/equipments'), $image_name);
            $image_url = $image_name;
        }

        Equipment::create([
            'category_id' => $request->category_id ?: null,
            'name' => $request->name,
            'description' => $request->description,
            'price_per_day' => $request->price_per_day,
            'stock' => $request->stock,
            'status' => 'available',
            'image_url' => $image_url,
        ]);

        return redirect()->route('admin.peralatan.index')->with('success', 'Peralatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        $categories = Category::orderBy('category_name')->get();
        return view('admin.peralatan.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price_per_day' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $equipment = Equipment::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($equipment->image_url && file_exists(public_path('uploads/equipments/' . $equipment->image_url))) {
                unlink(public_path('uploads/equipments/' . $equipment->image_url));
            }
            $image = $request->file('image');
            $image_name = time() . '_' . rand(1000, 9999) . '.' . $image->extension();
            $image->move(public_path('uploads/equipments'), $image_name);
            $equipment->image_url = $image_name;
        }

        $equipment->category_id = $request->category_id ?: null;
        $equipment->name = $request->name;
        $equipment->description = $request->description;
        $equipment->price_per_day = $request->price_per_day;
        $equipment->stock = $request->stock;
        $equipment->status = $request->status;
        $equipment->save();

        return redirect()->route('admin.peralatan.index')->with('success', 'Peralatan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);

        $sedang_disewa = RentalItem::where('equipment_id', $id)
            ->whereHas('rental', function ($q) {
                $q->whereIn('status_payment', ['pending', 'paid']);
            })->exists();

        if ($sedang_disewa) {
            return back()->with('error', 'Alat tidak bisa dihapus karena sedang disewa!');
        }

        if ($equipment->image_url && file_exists(public_path('uploads/equipments/' . $equipment->image_url))) {
            unlink(public_path('uploads/equipments/' . $equipment->image_url));
        }

        $equipment->delete();

        return redirect()->route('admin.peralatan.index')->with('success', 'Peralatan berhasil dihapus!');
    }

    public function updateStatus($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('admin.peralatan.update_status', compact('equipment'));
    }

    public function changeStatus(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->status = $request->status;
        $equipment->save();

        return redirect()->route('admin.peralatan.index')->with('success', 'Status peralatan berhasil diupdate!');
    }
}
