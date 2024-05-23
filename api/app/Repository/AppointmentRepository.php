<?php

namespace App\Repository;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;

class AppointmentRepository
{
    public function isEmployeeAvailable(User $employee, Carbon $date, Carbon $time): bool
    {
        return Appointment::query()
            ->whereEmployeeId($employee->id)
            ->whereStartsAtDate($date)
            ->whereStartsAtTime($time)
            ->exists();
    }
}
