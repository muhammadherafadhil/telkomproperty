<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class RencanaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  // Agar hanya pengguna yang terautentikasi yang dapat mengakses
    }

    // Menampilkan semua rencana yang terkait dengan pengguna yang login
    public function index()
    {
        $plans = Plan::where('user_id', auth()->id())->get();
        return view('plans.index', compact('plans'));
    }

    // Menampilkan form untuk membuat rencana baru
    public function create()
    {
        return view('plans.create');
    }

    // Menyimpan rencana baru
    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Membuat rencana baru
        Plan::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status' => $validated['status'],
            'user_id' => auth()->id(),  // Mengaitkan dengan user yang sedang login
        ]);

        return redirect()->route('plans.index')->with('success', 'Rencana berhasil dibuat!');
    }

    // Menampilkan detail rencana berdasarkan ID
    public function show(Plan $plan)
    {
        // Memastikan hanya pemilik rencana yang bisa melihat
        if ($plan->user_id !== auth()->id()) {
            abort(403);  // Jika bukan pemilik rencana, tampilkan error 403
        }

        return view('plans.show', compact('plan'));
    }

    // Menampilkan form untuk mengedit rencana
    public function edit(Plan $plan)
    {
        // Memastikan hanya pemilik rencana yang bisa mengedit
        if ($plan->user_id !== auth()->id()) {
            abort(403);  // Jika bukan pemilik rencana, tampilkan error 403
        }

        return view('plans.edit', compact('plan'));
    }

    // Memperbarui data rencana yang sudah ada
    public function update(Request $request, Plan $plan)
    {
        // Memastikan hanya pemilik rencana yang bisa mengedit
        if ($plan->user_id !== auth()->id()) {
            abort(403);  // Jika bukan pemilik rencana, tampilkan error 403
        }

        // Validasi input yang diterima
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Memperbarui rencana dengan data yang baru
        $plan->update($validated);

        return redirect()->route('plans.index')->with('success', 'Rencana berhasil diperbarui!');
    }

    // Menghapus rencana
    public function destroy(Plan $plan)
    {
        // Memastikan hanya pemilik rencana yang bisa menghapus
        if ($plan->user_id !== auth()->id()) {
            abort(403);  // Jika bukan pemilik rencana, tampilkan error 403
        }

        $plan->delete();

        return redirect()->route('plans.index')->with('success', 'Rencana berhasil dihapus!');
    }
}
