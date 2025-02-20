<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeCount;  // Misalnya Anda menggunakan model untuk menyimpan data

class EmployeeController extends Controller
{
    // Ambil jumlah pegawai
    public function updateEmployeeCount(Request $request)
    {
        // Validasi input
        $request->validate([
            'count' => 'required|integer|min:0',
        ]);
    
        // Update data jumlah pegawai, sesuaikan dengan model yang digunakan
        try {
            // Misalnya, menggunakan model Settings untuk menyimpan jumlah pegawai
            Settings::updateOrCreate(
                ['key' => 'employee_count'],
                ['value' => $request->count]
            );
    
            // Kembalikan respon sukses
            return response()->json(['message' => 'Jumlah pegawai berhasil diperbarui!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui jumlah pegawai.'], 500);
        }
    }
}