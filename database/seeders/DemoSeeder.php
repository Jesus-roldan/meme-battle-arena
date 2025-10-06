<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Battle;
use App\Models\Meme;
use App\Models\Vote;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
         // Usuario conocido para pruebas
        User::factory()->create([
            'name' => 'Admin Demo',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        
        // Crear usuarios
        $users = User::factory(10)->create();

        // Crear batallas
        $battles = Battle::factory(5)->create();

        // Crear memes (3 por battle)
        foreach ($battles as $battle) {
            Meme::factory(3)->create([
                'battle_id' => $battle->id,
                'user_id' => $users->random()->id,
            ]);
        }

        // Crear votos aleatorios (1 voto por usuario por batalla)
        $battles->each(function ($battle) use ($users) {
            foreach ($users as $user) {
                $meme = $battle->memes->random();
                Vote::factory()->create([
                    'user_id' => $user->id,
                    'battle_id' => $battle->id,
                    'meme_id' => $meme->id,
                ]);
            }
        });
    }
}

