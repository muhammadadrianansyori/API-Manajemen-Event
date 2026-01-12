<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     * is_admin ditambahkan agar bisa diupdate melalui sistem.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_admin' // Tambahkan ini agar tidak error saat update/create admin
    ];

    /**
     * Kolom yang disembunyikan saat pemanggilan API.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data.
     * Memastikan is_admin selalu dibaca sebagai boolean (true/false) bukan string.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * JWT Identifier
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT Custom Claims
     */
    public function getJWTCustomClaims()
    {
        // Anda bisa menambahkan 'role' di sini jika ingin role masuk ke dalam payload token
        return [
            'is_admin' => $this->is_admin
        ];
    }

    /**
     * Relasi ke tabel Participants
     */
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * Relasi ke tabel Events (Event yang dibuat oleh user ini)
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }
}
