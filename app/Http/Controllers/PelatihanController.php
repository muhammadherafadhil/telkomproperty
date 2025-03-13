<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PelatihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pelatihans = Pelatihan::where('nik', Auth::user()->nik)->latest()->paginate(10);
        return view('others.pelatihan.index', compact('pelatihans'));
    }

    public function create()
    {
        return view('others.pelatihan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelatihan' => 'required|string|max:255',
            'tanggal_pelatihan' => 'required|date',
            'tanggal_selesai_pelatihan' => 'nullable|date|after_or_equal:tanggal_pelatihan',
            'nama_penyelenggara' => 'required|string|max:255',
            'lamp_pelatihan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $pelatihan = Pelatihan::savePelatihan($request);

            if (!$pelatihan) {
                throw new \Exception('Gagal menyimpan pelatihan.');
            }

            DB::commit();
            return redirect()->route('pelatihan.index')->with('success', 'Data pelatihan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        return view('others.pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, $id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        $request->validate([
            'pelatihan' => 'required|string|max:255',
            'tanggal_pelatihan' => 'required|date',
            'tanggal_selesai_pelatihan' => 'nullable|date|after_or_equal:tanggal_pelatihan',
            'nama_penyelenggara' => 'required|string|max:255',
            'lamp_pelatihan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('lamp_pelatihan')) {
            if ($pelatihan->lamp_pelatihan) {
                Storage::disk('public')->delete($pelatihan->lamp_pelatihan);
            }
            $pelatihan->lamp_pelatihan = $request->file('lamp_pelatihan')->store('pelatihan', 'public');
        }

        $pelatihan->update($request->only(['pelatihan', 'tanggal_pelatihan', 'tanggal_selesai_pelatihan', 'nama_penyelenggara']));

        return redirect()->route('pelatihan.index')->with('success', 'Data pelatihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        if ($pelatihan->lamp_pelatihan) {
            Storage::disk('public')->delete($pelatihan->lamp_pelatihan);
        }

        $pelatihan->delete();

        return redirect()->route('pelatihan.index')->with('success', 'Data pelatihan berhasil dihapus.');
    }
}
