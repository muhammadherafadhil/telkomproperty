<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendidikan;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PendidikanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pendidikans = Pendidikan::where('nik', Auth::user()->nik)->latest()->paginate(10);
        return view('others.pendidikan.index', compact('pendidikans'));
    }

    public function create()
    {
        $jenjangPendidikanOptions = [
            'SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'
        ];
    
        return view('others.pendidikan.create', compact('jenjangPendidikanOptions'));
    }
    
    public function edit($id)
    {
        $pendidikan = Pendidikan::findOrFail($id);
        
        $jenjangPendidikanOptions = [
            'SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'
        ];
    
        return view('others.pendidikan.edit', compact('pendidikan', 'jenjangPendidikanOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenjang_pendidikan' => 'required|string|max:255',
            'institusi' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_lulus' => 'required|integer|min:1900|max:' . date('Y'),
            'lamp_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $pendidikan = Pendidikan::savePendidikan($request);

            if (!$pendidikan) {
                throw new \Exception('Gagal menyimpan pendidikan.');
            }

            DB::commit();
            return redirect()->route('pendidikan.index')->with('success', 'Data pendidikan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $pendidikan = Pendidikan::findOrFail($id);

        $request->validate([
            'jenjang_pendidikan' => 'required|string|max:255',
            'institusi' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_lulus' => 'required|integer|min:1900|max:' . date('Y'),
            'lamp_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('lamp_ijazah')) {
            if ($pendidikan->lamp_ijazah) {
                Storage::disk('public')->delete($pendidikan->lamp_ijazah);
            }
            $pendidikan->lamp_ijazah = $request->file('lamp_ijazah')->store('pendidikan', 'public');
        }

        $pendidikan->update($request->only(['jenjang_pendidikan', 'institusi', 'jurusan', 'tahun_lulus']));

        return redirect()->route('pendidikan.index')->with('success', 'Data pendidikan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendidikan = Pendidikan::findOrFail($id);

        if ($pendidikan->lamp_ijazah) {
            Storage::disk('public')->delete($pendidikan->lamp_ijazah);
        }

        $pendidikan->delete();

        return redirect()->route('pendidikan.index')->with('success', 'Data pendidikan berhasil dihapus.');
    }
}
