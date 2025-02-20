<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // Menampilkan semua properti dengan pencarian dan filter
    public function index(Request $request)
    {
        // Ambil nilai dari query string atau set default
        $search = $request->input('search', '');
        $location = $request->input('location', '');
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', PHP_INT_MAX);

        // Query properti dengan filter
        $properties = Property::query();

        if ($search) {
            $properties = $properties->where('name', 'like', "%{$search}%")
                                     ->orWhere('location', 'like', "%{$search}%");
        }

        if ($location) {
            $properties = $properties->where('location', $location);
        }

        if ($minPrice) {
            $properties = $properties->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $properties = $properties->where('price', '<=', $maxPrice);
        }

        // Ambil hasil dan paginasi
        $properties = $properties->paginate(10);

        // Kirim variabel ke view
        return view('properties.index', compact('properties', 'search', 'location', 'minPrice', 'maxPrice'));
    }

    // Menampilkan form untuk membuat properti baru
    public function create()
    {
        return view('properties.create');
    }

    // Menyimpan properti baru dan redirect ke halaman properties setelah berhasil
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|string',
        ]);

        // Simpan properti ke database
        Property::create($validated);

        // Redirect ke halaman properties setelah berhasil
        return redirect()->route('property.index')->with('success', 'Properti berhasil ditambahkan!');
    }

    // Menampilkan detail properti
    public function show($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.show', compact('property'));
    }

    // Menampilkan form untuk mengedit properti
    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.edit', compact('property'));
    }

    // Memperbarui properti
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|string',
        ]);

        // Update properti
        $property->update($validated);

        // Redirect kembali ke halaman properti dengan pesan sukses
        return redirect()->route('property.index')->with('success', 'Properti berhasil diperbarui!');
    }

    // Menghapus properti
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        // Redirect ke halaman properties dengan pesan sukses
        return redirect()->route('property.index')->with('success', 'Properti berhasil dihapus!');
    }
}
