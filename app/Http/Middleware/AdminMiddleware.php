<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan pengguna sudah login
        if (Auth::check()) {
            // Pastikan pengguna memiliki peran admin
            if (Auth::user()->role === 'admin') {
                return $next($request);
            }

            // Jika bukan admin, kembalikan respon JSON untuk API request
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Jika bukan request API, redirect ke halaman utama dengan pesan error
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        // Jika pengguna belum login, arahkan ke halaman login
        return redirect('/login')->with('error', 'Please login first.');
    }
}
