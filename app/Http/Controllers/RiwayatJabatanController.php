<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatJabatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RiwayatJabatanController extends Controller
{
    // Middleware untuk memastikan hanya pengguna yang terautentikasi yang dapat mengakses controller ini
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan daftar riwayat jabatan berdasarkan nik user yang sedang login
    public function index()
    {
        // Mengambil data riwayat jabatan berdasarkan nik dan dengan pagination
        $riwayatJabatans = RiwayatJabatan::where('nik', Auth::user()->nik)->latest()->paginate(10);
        
        // Mengirim data ke view
        return view('others.riwayat_jabatan.index', compact('riwayatJabatans'));
    }

    // Menampilkan form untuk menambahkan riwayat jabatan
    public function create()
    {
        return view('others.riwayat_jabatan.create');
    }

    // Menampilkan form untuk mengedit riwayat jabatan berdasarkan ID
    public function edit($id)
    {
        // Mencari riwayat jabatan berdasarkan ID
        $riwayatJabatan = RiwayatJabatan::findOrFail($id);

        // Mengirim data riwayat jabatan ke view
        return view('others.riwayat_jabatan.edit', compact('riwayatJabatan'));
    }

    // Menyimpan riwayat jabatan baru
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'lokasi_penempatan' => 'required|string|max:255',
            'tanggal_menjabat' => 'required|date',
            'tanggal_akhir_jabatan' => 'nullable|date',
            'lamp_jabatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Memulai transaksi database untuk memastikan atomisitas
        DB::beginTransaction();
        try {
            // Simpan riwayat jabatan melalui metode model
            $riwayatJabatan = RiwayatJabatan::saveRiwayatJabatan($request);

            if (!$riwayatJabatan) {
                throw new \Exception('Gagal menyimpan riwayat jabatan.');
            }

            // Jika berhasil, commit transaksi
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('riwayatjabatan.index')->with('success', 'Riwayat jabatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika ada error, rollback transaksi
            DB::rollBack();

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Mengupdate riwayat jabatan yang sudah ada
    public function update(Request $request, $id)
    {
        // Mencari riwayat jabatan berdasarkan ID
        $riwayatJabatan = RiwayatJabatan::findOrFail($id);

        // Validasi input dari form
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'lokasi_penempatan' => 'required|string|max:255',
            'tanggal_menjabat' => 'required|date',
            'tanggal_akhir_jabatan' => 'nullable|date',
            'lamp_jabatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Cek apakah ada file lampiran yang diunggah
        if ($request->hasFile('lamp_jabatan')) {
            // Hapus lampiran lama jika ada
            if ($riwayatJabatan->lamp_jabatan) {
                Storage::disk('public')->delete($riwayatJabatan->lamp_jabatan);
            }

            // Simpan lampiran baru
            $riwayatJabatan->lamp_jabatan = $request->file('lamp_jabatan')->store('riwayat_jabatan', 'public');
        }

        // Update data riwayat jabatan dengan data baru dari form
        $riwayatJabatan->update($request->only(['nama_jabatan', 'lokasi_penempatan', 'tanggal_menjabat', 'tanggal_akhir_jabatan']));

        // Redirect dengan pesan sukses
        return redirect()->route('riwayatjabatan.index')->with('success', 'Riwayat jabatan berhasil diperbarui.');
    }

    // Menghapus riwayat jabatan berdasarkan ID
    public function destroy($id)
    {
        // Mencari riwayat jabatan berdasarkan ID
        $riwayatJabatan = RiwayatJabatan::findOrFail($id);

        // Hapus lampiran jika ada
        if ($riwayatJabatan->lamp_jabatan) {
            Storage::disk('public')->delete($riwayatJabatan->lamp_jabatan);
        }

        // Hapus riwayat jabatan
        $riwayatJabatan->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('riwayatjabatan.index')->with('success', 'Riwayat jabatan berhasil dihapus.');
    }
}
