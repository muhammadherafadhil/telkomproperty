<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryLog;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class LogInteractionController extends Controller
{
    /**
     * Handle Like/Unlike pada log aktivitas.
     */
    public function like($id)
    {
        $log = HistoryLog::findOrFail($id);
        $user = Auth::user();

        // Cek apakah user sudah like
        $like = $log->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete(); // Jika sudah like, hapus (unlike)
            $liked = false;
        } else {
            $log->likes()->create(['user_id' => $user->id]); // Jika belum like, tambahkan
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'likes' => $log->likes()->count(),
            'liked' => $liked
        ]);
    }

    /**
     * Handle penambahan komentar pada log aktivitas.
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $log = HistoryLog::findOrFail($id);

        $log->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
