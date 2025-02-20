<?php

use Illuminate\Http\Request;
use App\Models\HistoryLog;
use App\Models\LogComment;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function likeLog($id)
    {
        $log = HistoryLog::findOrFail($id);
        $log->increment('likes_count');

        return response()->json(['likes' => $log->likes_count]);
    }

    public function commentLog(Request $request, $id)
    {
        $log = HistoryLog::findOrFail($id);
        $comment = new LogComment();
        $comment->history_log_id = $id;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;
        $comment->save();

        return response()->json([
            'user' => Auth::user()->name,
            'content' => $comment->content,
            'comments' => $log->comments()->count()
        ]);
    }
}
