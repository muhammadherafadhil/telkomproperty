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
            'nama' => '', // Kosongkan, user bisa mengisi nanti
            'jabatan' => '', // Kosongkan atau berikan nilai default jika diperlukan
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
