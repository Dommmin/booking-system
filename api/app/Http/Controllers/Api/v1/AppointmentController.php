<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentStoreRequest;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller
{
    public function __construct(private readonly AppointmentService $appointmentService)
    {
    }

    public function store(AppointmentStoreRequest $request, Service $service, ?User $employee = null)
    {
//        if (! Gate::allows('view', [EmployeeService::class, $service, $employee])) {
//            abort(404);
//        }

        $validated = $request->validated();

        $date = Carbon::create($validated['starts_at_date']);
        $time = Carbon::parse($validated['starts_at_time']);

        $validated['employee_id'] = $this->appointmentService->getEmployeeId($employee, $service, $date, $time);
        $validated['service_id'] = $service->id;
        $validated['client_id'] = $request->user()->id;
        $validated['starts_at_date'] = $date->format('Y-m-d');

        return Appointment::create($validated);
    }

    public function cancel(Appointment $appointment)
    {
        Gate::authorize('update', $appointment);

        $appointment->update(['canceled_at' => now()]);

        return response()->noContent();
    }
}
