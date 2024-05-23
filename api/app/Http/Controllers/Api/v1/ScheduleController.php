<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ScheduleController extends Controller
{
    public function index(User $employee)
    {
        $schedules = $employee->schedule()->first();

        return new ScheduleResource($schedules);
    }

    public function store(ScheduleStoreRequest $request, User $employee)
    {
        Gate::authorize('create', Schedule::class);
        Gate::allowIf(function () use ($employee) {
            return $employee->hasRole(RolesEnum::Employee->value);
        });

        $validated = $request->validated();
        $validated['employee_id'] = $employee->id;

        return Schedule::create($validated);
    }
}
