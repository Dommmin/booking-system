<?php

namespace App\Repository;

use App\Models\Appointment;
use App\Models\EmployeeService;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkBreak;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UserRepository
{
    /**
     * @param  string  $slug
     * @param  array  $columns
     *
     * @return User
     */
    public function getEmployeeBySlug(string $slug, array $columns = ['*']): User
    {
        return User::employee()
            ->whereSlug($slug)
            ->firstOrFail($columns);
    }

    /**
     * @param  Service  $service
     *
     * @return Collection
     */
    public function getEmployeesByService(Service $service): Collection
    {
        $employeeIds = EmployeeService::query()
            ->whereServiceId($service->id)
            ->pluck('employee_id')
            ->toArray();

        return User::whereIn('id', $employeeIds)->get();
    }

    /**
     * @param  User  $user
     * @param  array  $columns
     *
     * @return Schedule
     */
    public function getUserSchedule(User $user, array $columns = ['*']): Schedule
    {
        return Schedule::query()
            ->whereEmployeeId($user->id)
            ->first($columns);
    }

    /**
     * @param  User  $employee
     * @param  Carbon  $date
     *
     * @return Collection
     */
    public function getEmployeeWorkBreaksByDate(User $employee, Carbon $date): Collection
    {
        return WorkBreak::query()
            ->whereEmployeeId($employee->id)
            ->whereStartsAtDate($date)
            ->get();
    }

    /**
     * @param  User $employee
     * @param  Carbon $date
     * @param  bool $notCancelled
     *
     * @return Collection
     */
    public function getEmployeeServiceAppointmentsByDate(
        User $employee,
        Carbon $date,
        bool $notCancelled = true
    ): Collection {
        $query = Appointment::query()
            ->whereEmployeeId($employee->id)
            ->whereStartsAtDate($date);

        if ($notCancelled) {
            $query->notCancelled();
        }

        return $query->get();
    }
}
