<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function memes()
    {
        return $this->hasMany(Meme::class);
    }
    
     public function scopeOpen($query)
    {
        return $query->where('deadline', '>=', now());
    }
}

