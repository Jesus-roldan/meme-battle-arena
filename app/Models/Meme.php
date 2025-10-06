<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meme extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'battle_id',
        'image_path',
        'caption',
        'approved',
        'votes_count'
    ];

    protected $casts = [
        'approved' => 'boolean',
        'votes_count' => 'integer',
    ];

    public function battle()
    {
        return $this->belongsTo(Battle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}

