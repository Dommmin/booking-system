<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Models\User;

class SchedulePolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole(RolesEnum::Admin->value) || $user->hasRole(RolesEnum::Manager->value);
    }
}
