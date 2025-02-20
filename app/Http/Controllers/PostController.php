<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function beranda()
    {
        // Mengambil semua postingan dengan relasi user, komentar, dan like
        $posts = Post::with(['user', 'comments.user', 'likes'])->latest()->get();
        
        // Mengembalikan view beranda dengan data postingan
        return view('beranda', compact('posts'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'content' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Jika ada gambar yang diupload, simpan ke penyimpanan
        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('post_images', 'public')
            : null;

        // Membuat postingan baru
        Post::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('beranda');
    }

    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post = Post::findOrFail($postId);
        
        $post->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('beranda');
    }

    public function likePost($postId)
    {
        $post = Post::findOrFail($postId);
        
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            $post->likes()->create([
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('beranda');
    }
}
