<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPegawai;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryLog;

class DataPegawaiController extends Controller
{
    // Menampilkan data pegawai
    public function index()
    {
        $user = Auth::user();

        // Validasi jika user tidak ditemukan
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Ambil data pegawai berdasarkan NIK pengguna yang login
        $dataPegawai = DataPegawai::where('nik', $user->nik)->first();

        // Jika data tidak ditemukan
        if (!$dataPegawai) {
            return redirect()->route('beranda')->with('error', 'Data pegawai tidak ditemukan.');
        }

        // Kirim satu data pegawai ke view
        return view('data-pegawai.index', compact('dataPegawai'));
    }

    // Menampilkan form edit data pegawai
    public function edit($nik)
    {
        $user = Auth::user();
        $dataPegawai = DataPegawai::where('nik', $nik)->first();

        // Ambil semua data provinsi
        $provinsi = Provinsi::all();

        // Pastikan hanya admin atau pemilik data yang bisa mengakses halaman ini
        if ($user->role !== 'admin' && $dataPegawai->nik !== $user->nik) {
            return redirect()->route('data-pegawai.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        // Kirim data ke view
        return view('data-pegawai.edit', compact('dataPegawai', 'provinsi'));
    }

    // Method untuk mendapatkan kabupaten berdasarkan provinsi
    public function getKabupaten($id_prov)
    {
        $kabupaten = Kabupaten::where('id_prov', $id_prov)->select('id_kab', 'nama')->get();
        return response()->json($kabupaten);
    }

    // Method untuk mendapatkan kecamatan berdasarkan kabupaten
    public function getKecamatan($id_kab)
    {
        $kecamatan = Kecamatan::where('id_kab', $id_kab)->select('id_kec', 'nama')->get();
        return response()->json($kecamatan);
    }

    // Method untuk mendapatkan kelurahan berdasarkan kecamatan
    public function getKelurahan($id_kec)
    {
        $kelurahan = Kelurahan::where('id_kec', $id_kec)->select('id_kel', 'nama')->get();
        return response()->json($kelurahan);
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
            'nama_lengkap' => 'nullable|string|max:255',
            'nama_posisi' => 'nullable|string|max:255',
            'klasifikasi_posisi' => 'nullable|string|max:255',
            'lokasi_kerja' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'psa' => 'nullable|string|max:255',
            'nik_tg' => 'nullable|string|max:10',
            'level_eksis' => 'nullable|string|max:255',
            'tanggal_level' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:255',
            'sex' => 'nullable|string|max:10',
            'gol_darah' => 'nullable|string|max:3',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'aktif_or_pensiun' => 'nullable|string|max:50',
            'nomor_ktp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'rt_rw' => 'nullable|string|max:20',
            'des_kel' => 'nullable|string|max:255',
            'kec' => 'nullable|string|max:255',
            'kab_kot' => 'nullable|string|max:255',
            'prov' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'no_hp' => 'nullable|string|max:15',
            'email_telpro' => 'nullable|email|max:255',
            'other_email' => 'nullable|email|max:255',
            'tanggal_mulai_kerja' => 'nullable|date',
            'status_karyawan' => 'nullable|string|max:50',
            'no_sk_kartap' => 'nullable|string|max:50',
            'tanggal_kartap' => 'nullable|date',
            'no_sk_promut' => 'nullable|string|max:50',
            'tanggal_promut' => 'nullable|date',
            'kode_divisi' => 'nullable|string|max:50',
            'nama_divisi' => 'nullable|string|max:255',
            'tgl_posisi' => 'nullable|date',
            'nama_kelompok_usia' => 'nullable|string|max:255',
            'kode_kelompok_usia' => 'nullable|string|max:50',
            'nama_employee_group' => 'nullable|string|max:255',
            'kota_kerja_now' => 'nullable|string|max:255',
            'unit_kerja_now' => 'nullable|string|max:255',
            'no_kontrak' => 'nullable|string|max:50',
            'mli_kontrak' => 'nullable|date',
            'end_kontrak' => 'nullable|date',
            'formasi_jabatan' => 'nullable|string|max:255',
            'status_nikah' => 'nullable|string|max:50',
            'tanggal_nikah' => 'nullable|date',
            'tang_kel' => 'nullable|string|max:255',
            'no_kk' => 'nullable|string|max:20',
            'nama_suami_or_istri' => 'nullable|string|max:255',
            'nomor_hp_pasangan' => 'nullable|string|max:15',
            'nama_anak_1' => 'nullable|string|max:255',
            'tgl_lahir_anak_1' => 'nullable|date',
            'nama_anak_2' => 'nullable|string|max:255',
            'tgl_lahir_anak_2' => 'nullable|date',
            'nama_anak_3' => 'nullable|string|max:255',
            'tgl_lahir_anak_3' => 'nullable|date',
            'nama_ayah_kandung' => 'nullable|string|max:255',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'no_bpjs_kes' => 'nullable|string|max:20',
            'no_bpjs_ket' => 'nullable|string|max:20',
            'no_telkomedika' => 'nullable|string|max:20',
            'npwp' => 'nullable|string|max:20',
            'nama_bank' => 'nullable|string|max:255',
            'no_rekening' => 'nullable|string|max:50',
            'nama_rekening' => 'nullable|string|max:255',
            'lamp_foto_karyawan' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_ktp' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_sk_kartap' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_sk_promut' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_kontrak' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_buku_nikah' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_kk' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_ktp_pasangan' => 'nullable|file|mimes:gif,jpeg,png,jpg|max:2048',
            'lamp_akta_1' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_akta_2' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_akta_3' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_bpjs_kes' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg,webp|max:2048',
            'lamp_bpjs_tk' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg,webp|max:2048',
            'lamp_kartu_npwp' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'lamp_buku_rekening' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
            'avatar_karyawan' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg|max:2048',
        ]);

        // Update data pegawai
        $dataPegawai->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nama_posisi' => $request->nama_posisi,
            'klasifikasi_posisi' => $request->klasifikasi_posisi,
            'lokasi_kerja' => $request->lokasi_kerja,
            'unit_kerja' => $request->unit_kerja,
            'psa' => $request->psa,
            'nik_tg' => $request->nik_tg,
            'level_eksis' => $request->level_eksis,
            'tanggal_level' => $request->tanggal_level,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'sex' => $request->sex,
            'gol_darah' => $request->gol_darah,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'aktif_or_pensiun' => $request->aktif_or_pensiun,
            'nomor_ktp' => $request->nomor_ktp,
            'alamat' => $dataPegawai->alamat,
            'rt_rw' => $request->rt_rw,
            'des_kel' => $request->des_kel,
            'kec' => $request->kec,
            'kab_kot' => $request->kab_kot,
            'prov' => $request->prov,
            'kode_pos' => $request->kode_pos,
            'no_hp' => $request->no_hp,
            'email_telpro' => $request->email_telpro,
            'other_email' => $request->other_email,
            'tanggal_mulai_kerja' => $request->tanggal_mulai_kerja,
            'status_karyawan' => $request->status_karyawan,
            'no_sk_kartap' => $request->no_sk_kartap,
            'tanggal_kartap' => $request->tanggal_kartap,
            'no_sk_promut' => $request->no_sk_promut,
            'tanggal_promut' => $request->tanggal_promut,
            'kode_divisi' => $request->kode_divisi,
            'nama_divisi' => $request->nama_divisi,
            'tgl_posisi' => $request->tgl_posisi,
            'nama_kelompok_usia' => $request->nama_kelompok_usia,
            'kode_kelompok_usia' => $request->kode_kelompok_usia,
            'nama_employee_group' => $request->nama_employee_group,
            'kota_kerja_now' => $request->kota_kerja_now,
            'unit_kerja_now' => $request->unit_kerja_now,
            'no_kontrak' => $request->no_kontrak,
            'mli_kontrak' => $request->mli_kontrak,
            'end_kontrak' => $request->end_kontrak,
            'formasi_jabatan' => $request->formasi_jabatan,
            'status_nikah' => $request->status_nikah,
            'tanggal_nikah' => $request->tanggal_nikah,
            'tang_kel' => $request->tang_kel,
            'no_kk' => $request->no_kk,
            'nama_suami_or_istri' => $request->nama_suami_or_istri,
            'nomor_hp_pasangan' => $request->nomor_hp_pasangan,
            'nama_anak_1' => $request->nama_anak_1,
            'tgl_lahir_anak_1' => $request->tgl_lahir_anak_1,
            'nama_anak_2' => $request->nama_anak_2,
            'tgl_lahir_anak_2' => $request->tgl_lahir_anak_2,
            'nama_anak_3' => $request->nama_anak_3,
            'tgl_lahir_anak_3' => $request->tgl_lahir_anak_3,
            'nama_ayah_kandung' => $request->nama_ayah_kandung,
            'nama_ibu_kandung' => $request->nama_ibu_kandung,
            'no_bpjs_kes' => $request->no_bpjs_kes,
            'no_bpjs_ket' => $request->no_bpjs_ket,
            'no_telkomedika' => $request->no_telkomedika,
            'npwp' => $request->npwp,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'nama_rekening' => $request->nama_rekening,
            'lamp_foto_karyawan' => $request->hasFile('lamp_foto_karyawan') ? $request->lamp_foto_karyawan->storeAs('storage', time() . '_' . $request->lamp_foto_karyawan->getClientOriginalName(), 'public') : $dataPegawai->lamp_foto_karyawan,
            'lamp_ktp' => $request->hasFile('lamp_ktp') ? $request->lamp_ktp->storeAs('storage', time() . '_' . $request->lamp_ktp->getClientOriginalName(), 'public') : $dataPegawai->lamp_ktp,
            'lamp_sk_kartap' => $request->hasFile('lamp_sk_kartap') ? $request->lamp_sk_kartap->storeAs('storage', time() . '_' . $request->lamp_sk_kartap->getClientOriginalName(), 'public') : $dataPegawai->lamp_sk_kartap,
            'lamp_sk_promut' => $request->hasFile('lamp_sk_promut') ? $request->lamp_sk_promut->storeAs('storage', time() . '_' . $request->lamp_sk_promut->getClientOriginalName(), 'public') : $dataPegawai->lamp_sk_promut,
            'lamp_kontrak' => $request->hasFile('lamp_kontrak') ? $request->lamp_kontrak->storeAs('storage', time() . '_' . $request->lamp_kontrak->getClientOriginalName(), 'public') : $dataPegawai->lamp_kontrak,
            'lamp_buku_nikah' => $request->hasFile('lamp_buku_nikah') ? $request->lamp_buku_nikah->storeAs('storage', time() . '_' . $request->lamp_buku_nikah->getClientOriginalName(), 'public') : $dataPegawai->lamp_buku_nikah,
            'lamp_kk' => $request->hasFile('lamp_kk') ? $request->lamp_kk->storeAs('storage', time() . '_' . $request->lamp_kk->getClientOriginalName(), 'public') : $dataPegawai->lamp_kk,
            'lamp_ktp_pasangan' => $request->hasFile('lamp_ktp_pasangan') ? $request->lamp_ktp_pasangan->storeAs('storage', time() . '_' . $request->lamp_ktp_pasangan->getClientOriginalName(), 'public') : $dataPegawai->lamp_ktp_pasangan,
            'lamp_akta_1' => $request->hasFile('lamp_akta_1') ? $request->lamp_akta_1->storeAs('storage', time() . '_' . $request->lamp_akta_1->getClientOriginalName(), 'public') : $dataPegawai->lamp_akta_1,
            'lamp_akta_2' => $request->hasFile('lamp_akta_2') ? $request->lamp_akta_2->storeAs('storage', time() . '_' . $request->lamp_akta_2->getClientOriginalName(), 'public') : $dataPegawai->lamp_akta_2,
            'lamp_akta_3' => $request->hasFile('lamp_akta_3') ? $request->lamp_akta_3->storeAs('storage', time() . '_' . $request->lamp_akta_3->getClientOriginalName(), 'public') : $dataPegawai->lamp_akta_3,
            'lamp_bpjs_kes' => $request->hasFile('lamp_bpjs_kes') ? $request->lamp_bpjs_kes->storeAs('storage', time() . '_' . $request->lamp_bpjs_kes->getClientOriginalName(), 'public') : $dataPegawai->lamp_bpjs_kes,
            'lamp_bpjs_tk' => $request->hasFile('lamp_bpjs_tk') ? $request->lamp_bpjs_tk->storeAs('storage', time() . '_' . $request->lamp_bpjs_tk->getClientOriginalName(), 'public') : $dataPegawai->lamp_bpjs_tk,
            'lamp_kartu_npwp' => $request->hasFile('lamp_kartu_npwp') ? $request->lamp_kartu_npwp->storeAs('storage', time() . '_' . $request->lamp_kartu_npwp->getClientOriginalName(), 'public') : $dataPegawai->lamp_kartu_npwp,
            'lamp_buku_rekening' => $request->hasFile('lamp_buku_rekening') ? $request->lamp_buku_rekening->storeAs('storage', time() . '_' . $request->lamp_buku_rekening->getClientOriginalName(), 'public') : $dataPegawai->lamp_buku_rekening,
            'avatar_karyawan' => $request->hasFile('avatar_karyawan') ? $request->avatar_karyawan->storeAs('storage', time() . '_' . $request->avatar_karyawan->getClientOriginalName(), 'public') : $dataPegawai->avatar_karyawan,
        ]);
        
        // Proses upload lampiran
        $lampiranFields = [
            'lamp_foto_karyawan',
            'lamp_ktp',
            'lamp_sk_kartap',
            'lamp_sk_promut',
            'lamp_kontrak',
            'lamp_buku_nikah',
            'lamp_kk',
            'lamp_ktp_pasangan',
            'lamp_akta_1',
            'lamp_akta_2',
            'lamp_akta_3',
            'lamp_bpjs_kes',
            'lamp_bpjs_tk',
            'lamp_kartu_npwp',
            'lamp_buku_rekening',
            'avatar_karyawan',
        ];

        // Log history
        $this->logHistory($dataPegawai, 'update');

        return redirect()->route('data-pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    private function logHistory($dataPegawai, $action)
    {
        $changes = $dataPegawai->getChanges(); // Mengambil data yang berubah
    
        // Menyimpan log ke tabel history_logs
        $historyLog = new HistoryLog();
        $historyLog->data_pegawai_id = $dataPegawai->id;
        $historyLog->action = $action; // Jenis aksi (create, update, delete)
    
        // Jika aksi adalah update, simpan data lama dan baru
        if ($action === 'update') {
            $historyLog->old_data = json_encode($dataPegawai->getOriginal()); // Data lama
            $historyLog->new_data = json_encode($changes); // Data baru
        } elseif ($action === 'create') {
            $historyLog->new_data = json_encode($changes); // Data baru (untuk create)
        } elseif ($action === 'delete') {
            $historyLog->old_data = json_encode($dataPegawai->getOriginal()); // Data lama (untuk delete)
        }
    
        // Menyimpan lampiran jika ada
        $oldAttachments = [];
        $newAttachments = [];
        
        // Cek lampiran lama
        if ($action === 'update') {
            $oldData = $dataPegawai->getOriginal();
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