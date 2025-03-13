<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hobi;
use App\Models\Keterampilan;
use App\Models\Pelatihan;
use App\Models\Pendidikan;
use App\Models\Penghargaan;
use App\Models\RiwayatJabatan;
use App\Models\HistoryLog; // Assuming you have a HistoryLog model

class OthersController extends Controller
{
    // ======= HOBI =======
    public function editHobi($nik)
    {
        $user = Auth::user();
        $hobi = Hobi::where('nik', $nik)->first();

        if (!$hobi) {
            return redirect()->route('data-pegawai.index')->with('error', 'Data hobi tidak ditemukan.');
        }

        if ($user->role !== 'admin' && $hobi->nik !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('others.hobi.edit', compact('hobi'));
    }

    public function updateHobi(Request $request, $nik)
    {
        $hobi = Hobi::where('nik', $nik)->first();

        if (!$hobi) {
            return redirect()->route('data-pegawai.index')->with('error', 'Data hobi tidak ditemukan.');
        }

        $oldData = $hobi->getOriginal(); // Data lama
        $hobi->update($request->all());

        // Mengelola file lampiran
        $lampiranFields = ['lamp_kegiatan_hobi'];
        foreach ($lampiranFields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                if ($hobi->$field) {
                    $oldFilePath = storage_path('app/public/storage' . $hobi->$field);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath); // Hapus file lama
                    }
                }

                // Ambil file yang diupload
                $file = $request->file($field);
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/storage', $filename);
                $hobi->$field = 'storage/' . $filename;
            }
        }

        $hobi->save();

        // Log history
        $this->logHistory($hobi, 'update', $oldData);

        return redirect()->route('data-pegawai.index')->with('success', 'Hobi berhasil diperbarui.');
    }

    // ======= KETERAMPILAN =======
    public function editKeterampilan($nik)
    {
        $user = Auth::user();
        $keterampilan = Keterampilan::where('nik', $nik)->first();

        if (!$keterampilan) {
            return redirect()->route('data-pegawai.index')->with('error', 'Data keterampilan tidak ditemukan.');
        }

        if ($user->role !== 'admin' && $keterampilan->nik !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
        return view('others.keterampilan.edit', compact('keterampilan'));
    }

    public function updateKeterampilan(Request $request, $nik)
    {
        $user = Auth::user();

        if ($user->nik !== $nik && $user->role !== 'admin') {
            return redirect()->route('data-pegawai.index')->with('error', 'Anda tidak memiliki akses untuk memperbarui data ini.');
        }

        $keterampilan = Keterampilan::where('nik', $nik)->first();

        if (!$keterampilan) {
            return redirect()->route('data-pegawai.index')->with('error', 'Data keterampilan tidak ditemukan.');
        }

        $oldData = $keterampilan->getOriginal(); // Data lama
        $keterampilan->update($request->all());

        // Mengelola file lampiran
        $lampiranFields = ['lamp_keterampilan'];
        foreach ($lampiranFields as $field) {
            if ($request->hasFile($field)) {
                if ($keterampilan->$field) {
                    $oldFilePath = storage_path('app/public/storage' . $keterampilan->$field);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath); // Hapus file lama
                    }
                }

                $file = $request->file($field);
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/storage', $filename);
                $keterampilan->$field = 'storage/' . $filename;
            }
        }

        $keterampilan->save();

        // Log history
        $this->logHistory($keterampilan, 'update', $oldData);

        return redirect()->route('data-pegawai.index')->with('success', 'Keterampilan berhasil diperbarui.');
    }

    // ======= PELATIHAN =======
    public function editPelatihan($nik)
    {
        $user = Auth::user();
        $pelatihan = Pelatihan::where('nik', $nik)->first();

        if (!$pelatihan) {
            return redirect()->route('data-pegawai.index')->with('error', 'Data pelatihan tidak ditemukan.');
        }

        if ($user->role !== 'admin' && $pelatihan->nik !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
        return view('others.pelatihan.edit', compact('pelatihan'));
    }

    public function updatePelatihan(Request $request, $nik)
    {
        $user = Auth::user();

        if ($user->nik !== $nik && $user->role !== 'admin') {
            return redirect()->route('data-pegawai.index')->with('error', 'Anda tidak memiliki akses untuk memperbarui data ini.');
        }

        $pelatihan = Pelatihan::where('nik', $nik)->first();

        if (!$pelatihan) {
            return redirect()->route('data-pegawai.index')->with('error', 'Data pelatihan tidak ditemukan.');
        }

        $oldData = $pelatihan->getOriginal(); // Data lama
        $pelatihan->update($request->all());

        // Mengelola file lampiran
        $lampiranFields = ['lamp_pelatihan'];
        foreach ($lampiranFields as $field) {
            if ($request->hasFile($field)) {
                if ($pelatihan->$field) {
                    $oldFilePath = storage_path('app/public/storage' . $pelatihan->$field);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath); // Hapus file lama
                    }
                }

                $file = $request->file($field);
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/storage', $filename);
                $pelatihan->$field = 'storage/' . $filename;
            }
        }

        $pelatihan->save();

        // Log history
        $this->logHistory($pelatihan, 'update', $oldData);

        return redirect()->route('data-pegawai.index')->with('success', 'Pelatihan berhasil diperbarui.');
    }

    // ======= PENDIDIKAN =======
    public function storePendidikan(Request $request)
    {
        $request->validate([
            'jenjang_pendidikan' => 'nullable|string',
            'institusi' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'tahun_lulus' => 'nullable|date',
            'lamp_ijazah' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
        ]);

        Pendidikan::create($request->all());
        return redirect()->route('data-pegawai.index')->with('success', 'Pendidikan berhasil ditambahkan.');
    }

    public function editPendidikan($nik)
    {
        $pendidikan = Pendidikan::findOrFail($nik);
        return view('others.pendidikan.edit', compact('pendidikan'));
    }

    public function updatePendidikan(Request $request, $nik)
    {
        $pendidikan = Pendidikan::findOrFail($nik);
        $oldData = $pendidikan->getOriginal(); // Data lama
        $pendidikan->update($request->all());

        // Log history
        $this->logHistory($pendidikan, 'update', $oldData);

        return redirect()->route('data-pegawai.index')->with('success', 'Pendidikan berhasil diperbarui.');
    }

    public function destroyPendidikan($nik)
    {
        Pendidikan::destroy($nik);
        return redirect()->route('data-pegawai.index')->with('success', 'Pendidikan berhasil dihapus.');
    }

    // ======= PENGHARGAAN =======
    public function storePenghargaan(Request $request)
    {
        $request->validate([
            'penghargaan' => 'nullable|string',
            'tahun_penghargaan' => 'nullable|date',
            'nama_penghargaan' => 'nullable|string',
            'lamp_penghargaan' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
        ]);

        Penghargaan::create($request->all());
        return redirect()->route('data-pegawai.index')->with('success', 'Penghargaan berhasil ditambahkan.');
    }

    public function editPenghargaan($nik)
    {
        $penghargaan = Penghargaan::findOrFail($nik);
        return view('others.penghargaan.edit', compact('penghargaan'));
    }

    public function updatePenghargaan(Request $request, $nik)
    {
        $penghargaan = Penghargaan::findOrFail($nik);
        $oldData = $penghargaan->getOriginal(); // Data lama
        $penghargaan->update($request->all());

        // Log history
        $this->logHistory($penghargaan, 'update', $oldData);

        return redirect()->route('data-pegawai.index')->with('success', 'Penghargaan berhasil diperbarui.');
    }

    public function destroyPenghargaan($nik)
    {
        Penghargaan::destroy($nik);
        return redirect()->route('data-pegawai.index')->with('success', 'Penghargaan berhasil dihapus.');
    }

    // ======= RIWAYAT JABATAN =======
    public function storeRiwayatJabatan(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'nullable|string',
            'tanggal_menjabat' => 'nullable|date',
            'tanggal_akhir_jabatan' => 'nullable|date',
            'lokasi_penempatan' => 'nullable|integer',
            'lamp_jabatan' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
        ]);

        RiwayatJabatan::create($request->all());
        return redirect()->route('data-pegawai.index')->with('success', 'Riwayat jabatan berhasil ditambahkan.');
    }

    public function editRiwayatJabatan($nik)
    {
        $riwayatJabatan = RiwayatJabatan::findOrFail($nik);
        return view('others.riwayat_jabatan.edit', compact('riwayatJabatan'));
    }

    public function updateRiwayatJabatan(Request $request, $nik)
    {
        $riwayatJabatan = RiwayatJabatan::findOrFail($nik);
        $oldData = $riwayatJabatan->getOriginal(); // Data lama
        $riwayatJabatan->update($request->all());

        // Log history
        $this->logHistory($riwayatJabatan, 'update', $oldData);

        return redirect()->route('data-pegawai.index')->with('success', 'Riwayat jabatan berhasil diperbarui.');
    }

    public function destroyRiwayatJabatan($nik)
    {
        RiwayatJabatan::destroy($nik);
        return redirect()->route('data-pegawai.index')->with('success', 'Riwayat jabatan berhasil dihapus.');
    }

    private function logHistory($dataPegawai, $action, $oldData = null)
    {
        $changes = $dataPegawai->getChanges(); // Mengambil data yang berubah

        // Menyimpan log ke tabel history_logs
        $historyLog = new HistoryLog();
        $historyLog->data_pegawai_id = $dataPegawai->id;
        $historyLog->action = $action; // Jenis aksi (create, update, delete)

        // Jika aksi adalah update, simpan data lama dan baru
        if ($action === 'update') {
            $historyLog->old_data = json_encode($oldData); // Data lama
            $historyLog->new_data = json_encode($changes); // Data baru
        } elseif ($action === 'create') {
            $historyLog->new_data = json_encode($changes); // Data baru (untuk create)
        } elseif ($action === 'delete') {
            $historyLog->old_data = json_encode($oldData); // Data lama (untuk delete)
        }

        // Menyimpan lampiran jika ada
        $oldAttachments = [];
        $newAttachments = [];

        // Cek lampiran lama
        if ($action === 'update') {
            foreach ($oldData as $key => $value) {
                if (strpos($key, 'lamp_') === 0 && !empty($value)) {
                    $oldAttachments[$key] = $value; // Menyimpan lampiran lama
                }
            }
            $historyLog->old_attachments = json_encode($oldAttachments); // Simpan lampiran lama
        }

        // Cek lampiran baru
        foreach ($changes as $key => $value) {
            if (strpos($key, 'lamp_') === 0 && !empty($value)) {
                $newAttachments[$key] = $value; // Menyimpan lampiran baru
            }
        }
        $historyLog->new_attachments = json_encode($newAttachments); // Simpan lampiran baru

        $historyLog->save(); // Simpan log ke database
    }
} 