<?php

namespace App\Policies;

use App\Models\Meme;
use App\Models\User;

class MemePolicy
{
    /**
     * Determina si el usuario puede actualizar el meme.
     */
    public function update(User $user, Meme $meme): bool
    {
        return $user->id === $meme->user_id;
    }

    /**
     * Determina si el usuario puede eliminar el meme.
     */
    public function delete(User $user, Meme $meme): bool
    {
        return $user->id === $meme->user_id;
    }
}

