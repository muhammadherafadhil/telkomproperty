<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keterampilan;
use App\Models\HistoryLog;
use App\Models\DataPegawai;
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
        $keterampilans = Keterampilan::where('nik', auth()->user()->nik)->latest()->paginate(10);
        $historyLogs = HistoryLog::where('data_pegawai_id', auth()->user()->id)->latest()->get();
        HistoryLog::where('new_data', '[]')->orWhereNull('new_data')->delete();
        return view('others.keterampilan.index', compact('keterampilans', 'historyLogs'));
    }

    public function create()
    {
        return view('others.keterampilan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterampilan' => 'required|string|max:255',
            'lamp_keterampilan' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg,avif|max:2048',
        ]);

        $lamp_keterampilan = $request->hasFile('lamp_keterampilan') 
            ? $request->file('lamp_keterampilan')->storeAs('keterampilan', time() . '_' . $request->file('lamp_keterampilan')->getClientOriginalName(), 'public') 
            : null;

        DB::beginTransaction();
        try {
            $keterampilan = Keterampilan::create([
                'nik' => auth()->user()->nik,
                'keterampilan' => $request->keterampilan,
                'lamp_keterampilan' => $lamp_keterampilan,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('keterampilan.index')->with('success', 'Data keterampilan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $keterampilan = Keterampilan::findOrFail($id);
        return view('others.keterampilan.edit', compact('keterampilan'));
    }

    public function update(Request $request, $id)
    {
        $keterampilan = Keterampilan::findOrFail($id);

        $request->validate([
            'keterampilan' => 'required|string|max:255',
            'lamp_keterampilan' => 'nullable|file|mimes:gif,pdf,jpeg,png,jpg,avif|max:2048',
        ]);

        $oldData = $keterampilan->toArray();

        if ($request->hasFile('lamp_keterampilan')) {
            if ($keterampilan->lamp_keterampilan) {
                Storage::disk('public')->delete($keterampilan->lamp_keterampilan);
            }
            $lamp_keterampilan = $request->file('lamp_keterampilan')->storeAs('keterampilan', time() . '_' . $request->file('lamp_keterampilan')->getClientOriginalName(), 'public');
            $keterampilan->lamp_keterampilan = $lamp_keterampilan;
        }

        $keterampilan->update($request->only(['keterampilan']));

        return redirect()->route('keterampilan.index')->with('success', 'Data keterampilan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keterampilan = Keterampilan::findOrFail($id);

        if ($keterampilan->lamp_keterampilan) {
            Storage::disk('public')->delete($keterampilan->lamp_keterampilan);
        }

        $keterampilan->delete();

        return redirect()->route('keterampilan.index')->with('success', 'Data keterampilan berhasil dihapus.');
    }
}
