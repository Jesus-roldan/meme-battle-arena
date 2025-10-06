<?php

namespace App\Policies;

use App\Models\Battle;
use App\Models\User;

class BattlePolicy
{
    /**
     * Determina si el usuario puede actualizar la batalla.
     */
    public function update(User $user, Battle $battle): bool
    {
        return $user->id === $battle->user_id;
    }

    /**
     * Determina si el usuario puede eliminar la batalla.
     */
    public function delete(User $user, Battle $battle): bool
    {
        return $user->id === $battle->user_id;
    }
}

