<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghargaan;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PenghargaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $penghargaans = Penghargaan::where('nik', Auth::user()->nik)->latest()->paginate(10);
        return view('others.penghargaan.index', compact('penghargaans'));
    }

    public function create()
    {
        return view('others.penghargaan.create');
    }
    
    public function edit($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        return view('others.penghargaan.edit', compact('penghargaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_penghargaan' => 'required|date',
            'nama_penghargaan' => 'required|string|max:255',
            'lamp_penghargaan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $penghargaan = Penghargaan::savePenghargaan($request);

            if (!$penghargaan) {
                throw new \Exception('Gagal menyimpan penghargaan.');
            }

            DB::commit();
            return redirect()->route('penghargaan.index')->with('success', 'Data penghargaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $penghargaan = Penghargaan::findOrFail($id);

        $request->validate([
            'tahun_penghargaan' => 'required|date',
            'nama_penghargaan' => 'required|string|max:255',
            'lamp_penghargaan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('lamp_penghargaan')) {
            if ($penghargaan->lamp_penghargaan) {
                Storage::disk('public')->delete($penghargaan->lamp_penghargaan);
            }
            $penghargaan->lamp_penghargaan = $request->file('lamp_penghargaan')->store('penghargaan', 'public');
        }

        $penghargaan->update($request->only(['tahun_penghargaan', 'nama_penghargaan']));

        return redirect()->route('penghargaan.index')->with('success', 'Data penghargaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);

        if ($penghargaan->lamp_penghargaan) {
            Storage::disk('public')->delete($penghargaan->lamp_penghargaan);
        }

        $penghargaan->delete();

        return redirect()->route('penghargaan.index')->with('success', 'Data penghargaan berhasil dihapus.');
    }
}
