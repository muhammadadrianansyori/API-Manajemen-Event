<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Menampilkan daftar semua log aktivitas (Hanya untuk Admin)
     */
    public function index()
    {
        // Mengambil log terbaru beserta data user yang melakukan aksi
        $logs = ActivityLog::with('user')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar log aktivitas berhasil diambil',
            'data'    => $logs
        ], 200);
    }
}
