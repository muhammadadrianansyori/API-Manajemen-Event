<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'event_date',
        'quota',
        'location',
        'category_id',
        'created_by', // <-- Pastikan baris ini ADA
    ];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke User (Creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
