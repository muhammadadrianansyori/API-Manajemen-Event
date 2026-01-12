<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\EventParticipantController;
use App\Http\Controllers\Api\ActivityLogController; // Pastikan ini di-import

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =======================
// AUTH (Public)
// =======================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// =======================
// PROTECTED ROUTES (JWT)
// =======================
Route::middleware('auth:api')->group(function () {

    // --- USER INFO & PERSONAL ---
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Fitur User untuk melihat daftar event yang sudah diikuti
    Route::get('/my-registrations', [ParticipantController::class, 'myRegistrations']);

    // --- AKSES DATA (Admin & User Bisa Lihat) ---
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);

    // Peserta bisa melihat daftar peserta di suatu event tertentu
    Route::get('/events/{id}/participants', [EventParticipantController::class, 'participants']);

    // User Daftar ke Event
    Route::post('/participants', [ParticipantController::class, 'store']);

    // --- AKSES KHUSUS ADMIN (Dibatasi Middleware 'admin') ---
    Route::middleware('admin')->group(function () {

        // Admin: Kelola Event
        Route::post('/events', [EventController::class, 'store']);
        Route::put('/events/{id}', [EventController::class, 'update']);
        Route::delete('/events/{id}', [EventController::class, 'destroy']);

        // Admin: Kelola Kategori
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        // Admin: Kelola Status Peserta
        Route::patch('/participants/{id}/status', [ParticipantController::class, 'updateStatus']);

        // Admin: CRUD Peserta
        Route::apiResource('participants', ParticipantController::class)->except(['store']);

        // ==========================================
        // BARU: Log Aktivitas (Hanya Admin)
        // ==========================================
        Route::get('/logs', [ActivityLogController::class, 'index']);

    });
});
