<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;
use App\Models\Participant;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'event_date',
        'quota',
        'location',
        'category_id',
        'created_by',
    ];

    // 🔗 relasi ke category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 🔗 relasi ke user (creator event)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // 🔗 relasi ke participant
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
