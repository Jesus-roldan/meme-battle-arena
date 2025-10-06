<?php

namespace Database\Factories;

use App\Models\Battle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BattleFactory extends Factory
{
    protected $model = Battle::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'deadline' => now()->addDays(rand(1, 10)),
        ];
    }
}

