<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hobi;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class HobiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hobis = Hobi::where('nik', Auth::user()->nik)->latest()->paginate(10);
        return view('others.hobi.index', compact('hobis'));
    }

    public function create()
    {
        return view('others.hobi.create');
    }
    
    public function edit($id)
    {
        $hobi = Hobi::findOrFail($id);
        return view('others.hobi.edit', compact('hobi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hobi' => 'required|string|max:255',
            'lamp_kegiatan_hobi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $hobi = Hobi::saveHobi($request);

            if (!$hobi) {
                throw new \Exception('Gagal menyimpan hobi.');
            }

            DB::commit();
            return redirect()->route('hobi.index')->with('success', 'Data hobi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $hobi = Hobi::findOrFail($id);

        $request->validate([
            'hobi' => 'required|string|max:255',
            'lamp_kegiatan_hobi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('lamp_kegiatan_hobi')) {
            if ($hobi->lamp_kegiatan_hobi) {
                Storage::disk('public')->delete($hobi->lamp_kegiatan_hobi);
            }
            $hobi->lamp_kegiatan_hobi = $request->file('lamp_kegiatan_hobi')->store('hobi', 'public');
        }

        $hobi->update($request->only(['hobi']));

        return redirect()->route('hobi.index')->with('success', 'Data hobi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $hobi = Hobi::findOrFail($id);

        if ($hobi->lamp_kegiatan_hobi) {
            Storage::disk('public')->delete($hobi->lamp_kegiatan_hobi);
        }

        $hobi->delete();

        return redirect()->route('hobi.index')->with('success', 'Data hobi berhasil dihapus.');
    }
}
