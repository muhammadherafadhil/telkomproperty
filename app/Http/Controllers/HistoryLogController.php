<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\DataPegawai;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Hobi;
use App\Models\Pelatihan;
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
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login

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

        // Ambil foto karyawan dan hobi untuk setiap log
        foreach ($logs as $log) {
            $dataPegawai = DataPegawai::find($log->data_pegawai_id);
            $log->employee_photo = $dataPegawai ? $dataPegawai->photo : null; // Ambil foto karyawan

            // Ambil hobi terkait
            $hobi = Hobi::find($log->hobi_id); // Pastikan ada kolom hobi_id di tabel history_logs
            $log->hobi = $hobi ? $hobi->name : null; // Ambil nama hobi

            // Ambil lampiran jika ada
            $log->lampiran = $log->lampiran ? Storage::url($log->lampiran) : null; // Ambil URL lampiran
        }

        return view('beranda', compact('logs', 'recentProfilePhoto', 'user')); // Mengirimkan log dan foto profil terbaru ke halaman beranda
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
            $path = $lampiran->storeAs('public/hobi', $fileName); // Menyimpan file di folder 'public/hobi'

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
            'pelatihan_id' => $request->pelatihan_id ?? null, // ID Pelatihan jika ada
            'data_pegawai_id' => $dataPegawaiId,
            'action' => $action,
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
            'name' => $changeDescription,
            'user_id' => auth()->user()->id, // Menggunakan ID pengguna yang sedang login
            'lampiran' => $attachedFiles['lampiran'] ?? null, // Menyimpan file lampiran jika ada
            'hobi_id' => $request->hobi_id ?? null, // Menyimpan ID hobi jika ada
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
        // Mengambil logs dengan paginasi (Anda dapat menambahkan filter atau hubungan yang diperlukan)
        $logs = HistoryLog::with('dataPegawai', 'likes', 'comments', 'hobi') // Pastikan memuat hubungan seperti dataPegawai, likes, comments
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Tentukan jumlah item per halaman sesuai kebutuhan
        
        return view('history-log.index', compact('logs'));
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

    /**
     * Menampilkan log yang dipaginasi dengan history hobi.
     *
     * @return \Illuminate\View\View
     */
    public function showLogs()
    {
        $logs = HistoryLog::paginate(10); // Ambil log biasa
        $historyLogs = HistoryLog::where('hobi_id', '!=', null)->paginate(5); // Ambil log terkait hobi

        return view('your-view-name', compact('logs', 'historyLogs'));
    }
}
