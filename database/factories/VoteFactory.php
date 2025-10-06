<?php

namespace Database\Factories;

use App\Models\Vote;
use App\Models\User;
use App\Models\Meme;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition(): array
    {
        $meme = Meme::inRandomOrder()->first() ?? Meme::factory()->create();

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'battle_id' => $meme->battle_id,
            'meme_id' => $meme->id,
        ];
    }
}

