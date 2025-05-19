<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keterampilan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KeterampilanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $keterampilans = Keterampilan::where('nik', Auth::user()->nik)->latest()->paginate(10);
        return view('others.keterampilan.index', compact('keterampilans'));
    }

    public function create()
    {
        return view('others.keterampilan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterampilan' => 'required|string|max:255',
            'lamp_keterampilan' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,avif,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'keterampilan' => $request->keterampilan,
                'nik' => Auth::user()->nik,
            ];

            if ($request->hasFile('lamp_keterampilan')) {
                $data['lamp_keterampilan'] = $request->file('lamp_keterampilan')->store('keterampilan', 'public');
            }

            $keterampilan = Keterampilan::create($data);

            if (!$keterampilan) {
                throw new \Exception('Gagal menyimpan data keterampilan.');
            }

            DB::commit();
            return redirect()->route('keterampilan.index')->with('success', 'Data keterampilan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $keterampilan = Keterampilan::findOrFail($id);

        if ($keterampilan->nik !== Auth::user()->nik) {
            abort(403, 'Tidak diizinkan.');
        }

        return view('others.keterampilan.edit', compact('keterampilan'));
    }

    public function update(Request $request, $id)
    {
        $keterampilan = Keterampilan::findOrFail($id);

        if ($keterampilan->nik !== Auth::user()->nik) {
            abort(403, 'Tidak diizinkan.');
        }

        $request->validate([
            'keterampilan' => 'required|string|max:255',
            'lamp_keterampilan' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,avif,webp|max:2048',
        ]);

        if ($request->hasFile('lamp_keterampilan')) {
            if ($keterampilan->lamp_keterampilan) {
                Storage::disk('public')->delete($keterampilan->lamp_keterampilan);
            }
            $keterampilan->lamp_keterampilan = $request->file('lamp_keterampilan')->store('keterampilan', 'public');
        }

        $keterampilan->update([
            'keterampilan' => $request->keterampilan,
        ]);

        return redirect()->route('keterampilan.index')->with('success', 'Data keterampilan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keterampilan = Keterampilan::findOrFail($id);

        if ($keterampilan->nik !== Auth::user()->nik) {
            abort(403, 'Tidak diizinkan.');
        }

        if ($keterampilan->lamp_keterampilan) {
            Storage::disk('public')->delete($keterampilan->lamp_keterampilan);
        }

        $keterampilan->delete();

        return redirect()->route('keterampilan.index')->with('success', 'Data keterampilan berhasil dihapus.');
    }
}
