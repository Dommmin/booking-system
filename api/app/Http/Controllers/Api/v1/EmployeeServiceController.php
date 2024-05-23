<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeServiceStoreRequest;
use App\Models\EmployeeService;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class EmployeeServiceController extends Controller
{
    public function index(User $employee)
    {
        return EmployeeService::query()
            ->whereEmployeeId($employee->id)
            ->with('service')
            ->get();
    }

    public function store(EmployeeServiceStoreRequest $request, User $employee)
    {
        Gate::authorize('create', EmployeeService::class);

        $validated = $request->validated();
        $validated['employee_id'] = $employee->id;

        return EmployeeService::create($validated);
    }

    public function destroy(EmployeeService $employeeService)
    {
        Gate::authorize('delete', $employeeService);

        $employeeService->delete();

        return response()->noContent();
    }
}
