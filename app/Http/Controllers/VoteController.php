<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meme;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function store(Request $request, Meme $meme)
    {
        $battle = $meme->battle;

        if ($battle->deadline->isPast()) {
            return back()->with('error','La batalla está cerrada.');
        }

        $userId = $request->user()->id;

        // Ya votó en esta batalla?
        $already = Vote::where('user_id', $userId)->where('battle_id', $battle->id)->exists();
        if ($already) {
            return back()->with('error','Ya has votado en esta batalla.');
        }

        // Crear voto en transacción y actualizar votes_count
        try {
            DB::transaction(function () use ($userId, $battle, $meme) {
                Vote::create([
                    'user_id' => $userId,
                    'battle_id' => $battle->id,
                    'meme_id' => $meme->id,
                ]);
                // Incremento atómico sobre la columna denormalizada
                $meme->increment('votes_count');
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // Catchear duplicado por constraint unique si ocurrió race condition
            return back()->with('error','No fue posible registrar el voto. Ya existe un voto previo.');
        }

        return back()->with('success','Voto registrado.');
    }

    // Opcional: retirar voto (si permites)
    public function destroy(Request $request, Meme $meme)
    {
        $userId = $request->user()->id;
        $vote = Vote::where('user_id', $userId)->where('battle_id', $meme->battle_id)->first();

        if (! $vote) {
            return back()->with('error','No existe tu voto en esta batalla.');
        }

        DB::transaction(function () use ($vote, $meme) {
            $vote->delete();
            $meme->decrement('votes_count');
        });

        return back()->with('success','Voto retirado.');
    }
}

