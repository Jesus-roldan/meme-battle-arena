<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'battle_id',
        'meme_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function battle()
    {
        return $this->belongsTo(Battle::class);
    }

    public function meme()
    {
        return $this->belongsTo(Meme::class);
    }
    
    protected static function booted()
    {
        static::created(function ($vote) {
            $vote->meme()->increment('votes_count');
        });

        static::deleted(function ($vote) {
            $vote->meme()->decrement('votes_count');
        });
    }
}

