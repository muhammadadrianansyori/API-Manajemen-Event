<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan baris ini!
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Menggunakan Facade Auth lebih stabil untuk deteksi VS Code
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'Akses ditolak! Hanya Admin yang boleh melakukan operasi ini.'
        ], 403);
    }
}
