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

        // Tambahkan data di tabel data_pegawai untuk semua role
        DataPegawai::create([
            'nik' => $user->nik,
            'nama_lengkap' => '', // Kosongkan, user bisa mengisi nanti
            'nama_posisi' => '',
            'nik_tg' => '',
            'klasifikasi_posisi' => '',
            'lokasi_kerja' => '',
            'unit_kerja' => '',
            'psa' => '',
            'level_eksis' => '',
            'tanggal_level' => '',
            'tempat_lahir' => '',
            'tanggal_lahir' => '',
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
            'tanggal_mulai_kerja' => '',
            'status_karyawan' => '',
            'no_sk_kartap' => '',
            'tanggal_kartap' => '',
            'no_sk_promut' => '',
            'tanggal_promut' => '',
            'kode_divisi' => '',
            'nama_divisi' => '',
            'tgl_posisi' => '',
            'nama_kelompok_usia' => '',
            'kode_kelompok_usia' => '',
            'nama_employee_group' => '',
            'kota_kerja_now' => '',
            'unit_kerja_now' => '',
            'no_kontrak' => '',
            'mli_kontrak' => '',
            'end_kontrak' => '',
            'formasi_jabatan' => '',
            'status_nikah' => '',
            'tanggal_nikah' => '',
            'tang_kel' => '',
            'no_kk' => '',
            'nama_suami_or_istri' => '',
            'nomor_hp_pasangan' => '',
            'nama_anak_1' => '',
            'tgl_lahir_anak_1' => '',
            'nama_anak_2' => '',
            'tgl_lahir_anak_2' => '',
            'nama_anak_3' => '',
            'tgl_lahir_anak_3' => '',
            'nama_ayah_kandung' => '',
            'nama_ibu_kandung' => '',
            'no_bpjs_ket' => '',
            'no_telkomedika' => '',
            'npwp' => '',
            'nama_bank' => '',
            'no_rekening' => '',
            'nama_rekening' => '',
            'lamp_foto_karyawan' => '',
            'lamp_ktp' => '',
            'lamp_sk' => '',
            'lamp_sk_kartap' => '',
            'lamp_sk_promut' => '',
            'lamp_buku_nikah' => '',
            'lamp_kk' => '',
            'lamp_ktp_pasangan' => '',
            'lamp_akta_1' => '',
            'lamp_akta_2' => '',
            'lamp_akta_3' => '',
            'lamp_bpjs_tk' => '',
            'lamp_kartu_npwp' => '',
            'lamp_buku_rekening' => '',
            'avatar_karyawan' => '',
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
