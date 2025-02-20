<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DataPegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form register (untuk admin saja)
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        
        $request->validate([
            'nik' => 'required|unique:users,nik',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user',
        ]);

        // Membuat user
        $user = User::create([
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'role' => $request->role,

        ]);

        $lampirans = [];
            foreach ([
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
                'lamp_buku_rekening'
            ] as $lampiran) {
    // Cek jika file ada
    if ($request->hasFile($lampiran)) {
        // Ambil file yang diupload
        $file = $request->file($lampiran);

        // Tentukan nama file unik dengan menambahkan timestamp atau ID unik
        $filename = time() . '_' . $file->getClientOriginalName();

        // Simpan file di folder 'uploads/lampiran' dalam storage publik
        $path = $file->storeAs('/storage', $filename, 'public');

        // Simpan path file ke array untuk digunakan nanti
        $lampirans[$lampiran] = $path;
    }
}

// Jika Anda ingin menyimpan path ke database atau melakukan sesuatu dengan $lampirans, lakukan di sini


// Menyimpan lampirans ke database atau digunakan sesuai kebutuhan


        // Tambahkan data di tabel data_pegawai untuk semua role
        DataPegawai::create([
            'nik' => $user->nik,
            'nama_lengkap' => '',
            'nama_posisi' => '',
            'klasifikasi_posisi' => '',
            'lokasi_kerja' => '',
            'unit_kerja' => '',
            'psa' => '',
            'nik_tg' => '',
            'level_eksis' => '',
            'tanggal_level' => null, // Format tanggal
            'tempat_lahir' => '',
            'tanggal_lahir' => null, // Format tanggal
            'agama' => '',
            'sex' => '',
            'gol_darah' => '',
            'pendidikan_terakhir' => '',
            'aktif_or_pensiun' => '',
            'nomor_ktp' => '',
            'alamat' => '',
            'rt_rw' => '',
            'des_kel' => '',
            'kec' => '',
            'kab_kot' => '',
            'prov' => '',
            'kode_pos' => '',
            'no_hp' => '',
            'email_telpro' => '',
            'other_email' => '',
            'tanggal_mulai_kerja' => null, // Format tanggal
            'status_karyawan' => '',
            'no_sk_kartap' => '',
            'tanggal_kartap' => null, // Format tanggal
            'no_sk_promut' => '',
            'tanggal_promut' => null, // Format tanggal
            'kode_divisi' => '',
            'nama_divisi' => '',
            'tgl_posisi' => null, // Format tanggal
            'nama_kelompok_usia' => '',
            'kode_kelompok_usia' => '',
            'nama_employee_group' => '',
            'kota_kerja_now' => '',
            'unit_kerja_now' => '',
            'no_kontrak' => '',
            'mli_kontrak' => null, // Format tanggal
            'end_kontrak' => null, // Format tanggal
            'formasi_jabatan' => '',
            'status_nikah' => '',
            'tanggal_nikah' => null, // Format tanggal
            'tang_kel' => '',
            'no_kk' => '',
            'nama_suami_or_istri' => '',
            'nomor_hp_pasangan' => '',
            'nama_anak_1' => '',
            'tgl_lahir_anak_1' => null, // Format tanggal
            'nama_anak_2' => '',
            'tgl_lahir_anak_2' => null, // Format tanggal
            'nama_anak_3' => '',
            'tgl_lahir_anak_3' => null, // Format tanggal
            'nama_ayah_kandung' => '',
            'nama_ibu_kandung' => '',
            'no_bpjs_kes' => '',
            'no_bpjs_ket' => '',
            'no_telkomedika' => '',
            'npwp' => '',
            'nama_bank' => '',
            'no_rekening' => '',
            'nama_rekening' => '',
            'lamp_foto_karyawan' => $lampirans['lamp_foto_karyawan'] ?? null,
            'lamp_ktp' => $lampirans['lamp_ktp'] ?? null,
            'lamp_sk_kartap' => $lampirans['lamp_sk_kartap'] ?? null,
            'lamp_sk_promut' => $lampirans['lamp_sk_promut'] ?? null,
            'lamp_kontrak' => $lampirans['lamp_kontrak'] ?? null,
            'lamp_buku_nikah' => $lampirans['lamp_buku_nikah'] ?? null,
            'lamp_kk' => $lampirans['lamp_kk'] ?? null,
            'lamp_ktp_pasangan' => $lampirans['lamp_ktp_pasangan'] ?? null,
            'lamp_akta_1' => $lampirans['lamp_akta_1'] ?? null,
            'lamp_akta_2' => $lampirans['lamp_akta_2'] ?? null,
            'lamp_akta_3' => $lampirans['lamp_akta_3'] ?? null,
            'lamp_bpjs_kes' => $lampirans['lamp_bpjs_kes'] ?? null,
            'lamp_bpjs_tk' => $lampirans['lamp_bpjs_tk'] ?? null,
            'lamp_kartu_npwp' => $lampirans['lamp_kartu_npwp'] ?? null,
            'lamp_buku_rekening' => $lampirans['lamp_buku_rekening'] ?? null,
            'avatar_karyawan' => null,
        ]);

        return redirect()->route('beranda')->with('success', 'User berhasil didaftarkan.');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('nik', 'password'))) {
            $request->session()->regenerate();

            return redirect()->route('beranda');
        }

        return back()->withErrors(['nik' => 'NIK atau password salah.']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
