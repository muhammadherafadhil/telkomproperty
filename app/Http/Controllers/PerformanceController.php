<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    /**
     * Konstruktor untuk mengautentikasi pengguna
     */
    public function __construct()
    {
        $this->middleware('auth'); // Hanya pengguna yang terautentikasi yang bisa mengakses
    }

    /**
     * Menampilkan daftar kinerja untuk pengguna saat ini (Admin atau User)
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            // Admin melihat semua laporan kinerja
            $performances = Performance::with('user')->get();
            return view('admin.performance.index', compact('performances'));
        } else {
            // Pengguna biasa hanya bisa melihat kinerjanya sendiri
            $performances = Performance::where('user_id', Auth::id())->get();
            return view('performance.index', compact('performances'));
        }
    }

    /**
     * Menampilkan form untuk menambah laporan kinerja dan daftar kinerja (untuk admin)
     */
    public function createForAdmin()
    {
        $users = User::all(); // Ambil semua pengguna
        $performances = Performance::with('user')->get(); // Ambil semua laporan kinerja
        
        // Kirim data pengguna dan laporan kinerja ke view
        return view('admin.performance.create', compact('users', 'performances'));
    }

    /**
     * Menyimpan laporan kinerja baru (untuk admin dan user)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:10',
            'score' => 'required|integer|min:1|max:5', // Pastikan score diberikan
        ]);

        // Menyimpan laporan kinerja
        $performance = new Performance();
        
        if (Auth::user()->isAdmin()) {
            // Jika admin, memilih user (pegawai) untuk kinerja
            $performance->user_id = $request->input('user_id');
        } else {
            // Jika pengguna biasa, simpan kinerja mereka sendiri
            $performance->user_id = Auth::id();
        }

        $performance->title = $request->input('title');
        $performance->description = $request->input('description');
        $performance->rating = $request->input('rating');
        $performance->score = $request->input('score');
        $performance->save();

        // Setelah kinerja disimpan, ambil kembali daftar kinerja
        $performances = Performance::with('user')->get();

        // Redirect ke halaman admin dengan daftar kinerja terbaru
        return redirect()->route('admin.performance.create')->with(compact('performances'))->with('success', 'Laporan kinerja berhasil disimpan.');
    }

    /**
     * Menampilkan form untuk membuat laporan kinerja untuk pengguna biasa
     */
    public function createForUser()
    {
        return view('performance.create'); // Tampilkan form pembuatan kinerja untuk pengguna biasa
    }

    /**
     * Menampilkan form untuk mengedit laporan kinerja
     */
    public function edit(Performance $performance)
    {
        // Mengizinkan hanya pemilik laporan yang dapat mengedit
        $this->authorize('update', $performance); 
        return view('performance.edit', compact('performance'));
    }

    /**
     * Memperbarui laporan kinerja
     */
    public function update(Request $request, Performance $performance)
    {
        // Mengizinkan hanya pemilik laporan yang dapat memperbarui
        $this->authorize('update', $performance); 

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:10',
            'score' => 'required|integer|min:1|max:5', // Pastikan score diberikan
        ]);

        // Memperbarui data performa
        $performance->title = $request->input('title');
        $performance->description = $request->input('description');
        $performance->rating = $request->input('rating');
        $performance->score = $request->input('score');
        $performance->save();

        return redirect()->route('performance.index')->with('success', 'Laporan kinerja berhasil diperbarui.');
    }

    /**
     * Menghapus laporan kinerja
     */
    public function destroy(Performance $performance)
    {
        // Mengizinkan hanya pemilik laporan yang dapat menghapus
        $this->authorize('delete', $performance); 
        $performance->delete();

        return redirect()->route('performance.index')->with('success', 'Laporan kinerja berhasil dihapus.');
    }

    /**
     * Admin melihat semua laporan kinerja
     */
    public function adminIndex()
    {
        // Hanya admin yang dapat melihat semua laporan kinerja
        $performances = Performance::with('user')->get();
        return view('admin.performance.index', compact('performances'));
    }
}
