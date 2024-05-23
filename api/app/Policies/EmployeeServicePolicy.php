<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Models\EmployeeService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeServicePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Service $service, ?User $employee = null): bool
    {
        return EmployeeService::query()
            ->whereServiceId($service->id)
            ->when($employee, function ($builder) use ($employee) {
                if ($employee) {
                    $builder->whereEmployeeId($employee->id);
                }
            })
            ->exists();
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RolesEnum::Admin->value) || $user->hasRole(RolesEnum::Manager->value);
    }

    public function delete(User $user): bool
    {
        return $user->hasRole(RolesEnum::Admin->value);
    }
}
