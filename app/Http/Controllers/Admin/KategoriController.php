<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('equipments')->orderBy('category_name')->get();
        return view('admin.kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Category::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,' . $id . ',category_id',
        ]);

        $kategori = Category::findOrFail($id);
        $kategori->category_name = $request->category_name;
        $kategori->save();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}