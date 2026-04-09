<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::with('category')->get();
        return view('admin.equipment.index', compact('equipment'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.equipment.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'total_qty' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        $data = $request->all();
        $data['available_qty'] = $data['total_qty']; // available matches total initially

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipment', 'public');
        }

        Equipment::create($data);
        return redirect()->route('admin.equipment.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Equipment $equipment)
    {
        $categories = Category::all();
        return view('admin.equipment.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'total_qty' => 'required|integer|min:0',
            'available_qty' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipment', 'public');
        }

        $equipment->update($data);
        return redirect()->route('admin.equipment.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('admin.equipment.index')->with('success', 'Alat berhasil dihapus.');
    }
}
