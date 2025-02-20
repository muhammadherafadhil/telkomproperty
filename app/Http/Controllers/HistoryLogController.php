<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\DataPegawai;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class HistoryLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan log yang dipaginasi di halaman beranda.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Paginasikan log untuk menampilkan 10 per halaman
        if ($user->is_admin) {
            $logs = HistoryLog::where('action', '!=', 'updated_at')
                ->latest()
                ->paginate(10); // Admin melihat log yang dipaginasi
        } else {
            $logs = HistoryLog::latest()->paginate(10); // Pengguna biasa melihat log yang dipaginasi
        }

        // Ambil foto profil terbaru
        $recentProfilePhoto = $this->getMostRecentProfilePhoto();

        // Ambil foto karyawan untuk setiap log
        foreach ($logs as $log) {
            $dataPegawai = DataPegawai::find($log->data_pegawai_id);
            $log->employee_photo = $dataPegawai ? $dataPegawai->photo : null; // Ambil foto karyawan
        }

        return view('beranda', compact('logs', 'recentProfilePhoto')); // Mengirimkan log dan foto profil terbaru ke halaman beranda
    }

    /**
     * Menyimpan entri log baru.
     *
     * @param  int  $dataPegawaiId
     * @param  string  $action
     * @param  array  $oldData
     * @param  array  $newData
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLog($dataPegawaiId, $action, $oldData, $newData, Request $request)
    {
        $dataPegawai = DataPegawai::find($dataPegawaiId);

        if (!$dataPegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan');
        }

        // Handle foto karyawan atau file lainnya
        $attachedFiles = [];
        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran');
            $fileName = Str::random(40) . '.' . $lampiran->getClientOriginalExtension();
            $path = $lampiran->storeAs('public/lampiran', $fileName); // Menyimpan file di storage

            // Dapatkan URL file untuk ditampilkan
            $attachedFiles['lampiran'] = Storage::url($path);
        }

        $changes = [];
        foreach ($oldData as $key => $value) {
            if (isset($newData[$key]) && $value != $newData[$key]) {
                $changes[] = "$key berubah dari $value menjadi {$newData[$key]}";
            }
        }
        $changeDescription = implode(', ', $changes);

        HistoryLog::create([
            'data_pegawai_id' => $dataPegawaiId,
            'action' => $action,
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
            'name' => $changeDescription,
            'user_id' => auth()->user()->id,
            'lampiran' => $attachedFiles['lampiran'] ?? null, // Menyimpan file lampiran jika ada
        ]);
    }

    /**
     * Memperbarui entri log yang sudah ada.
     *
     * @param  int  $logId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLog($logId, Request $request)
    {
        $log = HistoryLog::find($logId);
        if (!$log) {
            return redirect()->back()->with('error', 'Log tidak ditemukan');
        }

        $oldData = json_decode($log->old_data, true);
        $newData = json_decode($log->new_data, true);

        $changedData = [];
        foreach ($oldData as $key => $value) {
            if (isset($newData[$key]) && $value != $newData[$key]) {
                $changedData[$key] = ['old' => $value, 'new' => $newData[$key]]; 
            }
        }

        if (!empty($changedData)) {
            $log->update([
                'old_data' => json_encode($changedData),
                'new_data' => json_encode($changedData),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('logs.index');
    }

    /**
     * Menampilkan seluruh riwayat log dengan komentar dan like.
     *
     * @return \Illuminate\View\View
     */
    public function showHistoryLogs()
    {
        $historyLogs = HistoryLog::with(['comments', 'likes.user'])->paginate(10); // Paginasikan riwayat log
        return view('history-log.index', compact('historyLogs'));
    }

    /**
     * Menyimpan komentar untuk entri riwayat log tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'history_log_id' => 'required|exists:history_logs,id'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'history_log_id' => $request->history_log_id,
            'content' => $request->content,
        ]);

        return back();
    }

    /**
     * Memberi like atau menghapus like pada log riwayat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function likeHistoryLog(Request $request)
    {
        $historyLog = HistoryLog::findOrFail($request->history_log_id);

        $like = $historyLog->likes()->where('user_id', Auth::id())->first();
        if ($like) {
            $like->delete(); // Jika sudah memberi like, hapus like
        } else {
            $historyLog->likes()->create(['user_id' => Auth::id()]); // Tambahkan like baru
        }

        return back();
    }

    /**
     * Memvalidasi log untuk status (approved/rejected).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateLog(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $log = HistoryLog::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $log->update([
            'validation_status' => $request->status,
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return response()->json(['message' => 'Validation updated successfully']);
    }

    /**
     * Mengambil foto profil terbaru untuk ditampilkan.
     *
     * @return string
     */
    public function getMostRecentProfilePhoto()
    {
        // Tentukan path direktori
        $directory = storage_path('app/public/storage'); // Corrected to use storage_path

        // Pastikan direktori ada
        if (!File::exists($directory)) {
            return 'storage/default-profile.jpg'; // Fallback jika direktori tidak ada
        }

        // Ambil semua file dalam direktori
        $files = File::files($directory);

        // Urutkan file berdasarkan waktu modifikasi terakhir, dari yang terbaru
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        // Ambil file terbaru (pertama dalam array yang sudah diurutkan)
        $mostRecentFile = $files[0] ?? null;

        // Kembalikan path file relatif terhadap folder 'public'
        if ($mostRecentFile) {
            return 'storage/storage/' . basename($mostRecentFile);
        }

        return 'storage/default-profile.jpg'; // Fallback jika tidak ada file
    }
}
