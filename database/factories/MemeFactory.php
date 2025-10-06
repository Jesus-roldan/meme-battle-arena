<?php

namespace Database\Factories;

use App\Models\Meme;
use App\Models\User;
use App\Models\Battle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemeFactory extends Factory
{
    protected $model = Meme::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'battle_id' => Battle::inRandomOrder()->first()?->id ?? Battle::factory(),
            'caption' => $this->faker->sentence(),
            'approved' => true,
            'votes_count' => 0,
            'image_path' => function () {
                $randomName = Str::uuid();
                $imageUrl = "https://picsum.photos/1024/768.webp?random={$randomName}";
                $path = "memes/{$randomName}.webp";
                Storage::disk('public')->put($path, file_get_contents($imageUrl));

                return $path;
            },
        ];
    }
}

