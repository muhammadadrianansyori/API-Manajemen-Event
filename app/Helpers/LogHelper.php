<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth; // Tambahkan ini agar tidak error
use Illuminate\Support\Facades\Request;

class LogHelper
{
    public static function saveLog($activity, $description = null)
    {
        // Gunakan Auth::guard('api')->id() agar lebih spesifik untuk JWT
        $userId = Auth::guard('api')->id();

        if ($userId) {
            ActivityLog::create([
                'user_id'     => $userId,
                'activity'    => $activity,
                'description' => $description,
                'ip_address'  => Request::ip(),
            ]);
        }
    }
}
