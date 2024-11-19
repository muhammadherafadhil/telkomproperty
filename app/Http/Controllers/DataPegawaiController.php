<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPegawai;
use Illuminate\Support\Facades\Auth;

class DataPegawaiController extends Controller
{
    // Menampilkan data pegawai
    public function index()
    {
        $user = Auth::user();

        // Jika role admin, tampilkan semua data pegawai
        if ($user->role === 'admin') {
            $dataPegawais = DataPegawai::all();
        } else {
            // Jika role user, tampilkan hanya data miliknya
            $dataPegawais = DataPegawai::where('nik', $user->nik)->get();
        }

        return view('data-pegawai.index', compact('dataPegawais'));
    }

    // Menampilkan form edit data pegawai
    public function edit($nik)
    {
        $user = Auth::user();
        $dataPegawai = DataPegawai::where('nik', $nik)->first();

        // Pastikan hanya admin atau pemilik data yang bisa mengakses
        if ($user->role !== 'admin' && $dataPegawai->nik !== $user->nik) {
            return redirect()->route('data-pegawai.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        return view('data-pegawai.edit', compact('dataPegawai'));
    }

    // Update data pegawai
    public function update(Request $request, $nik)
    {
        $user = Auth::user();
        $dataPegawai = DataPegawai::where('nik', $nik)->first();

        // Pastikan hanya admin atau pemilik data yang bisa mengakses
        if ($user->role !== 'admin' && $dataPegawai->nik !== $user->nik) {
            return redirect()->route('data-pegawai.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        // Update data pegawai
        $dataPegawai->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('data-pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }
}
