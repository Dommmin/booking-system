<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvailabilityRequest;
use App\Models\EmployeeService;
use App\Models\Service;
use App\Models\User;
use App\Repository\UserRepository;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class AvailabilityController extends Controller
{
    public function __construct(
        private readonly AvailabilityService $availabilityService,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(AvailabilityRequest $request, Service $service, ?User $employee = null)
    {
        if (! Gate::allows('view', [EmployeeService::class, $service, $employee])) {
            abort(404);
        }

        $validated = $request->validated();
        $date = Carbon::parse($validated['date']);

        $employees = $employee
            ? collect([$employee])
            : $this->userRepository->getEmployeesByService($service);

        $availableSlots = $this->availabilityService->getAvailableSlots($employees, $service, $date);

        return $this->availabilityService->transform($availableSlots);
    }
}
