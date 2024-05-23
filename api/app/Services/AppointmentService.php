<?php

namespace App\Services;

use App\Models\Service;
use App\Models\User;
use App\Repository\AppointmentRepository;
use App\Repository\UserRepository;

readonly class AppointmentService
{
    public function __construct(
        private AvailabilityService $availabilityService,
        private UserRepository $userRepository,
        private AppointmentRepository $appointmentRepository,
    ) {
    }

    public function getEmployeeId(?User $employee, Service $service, $date, $time)
    {
        if ($employee) {
            $this->checkEmployeeAvailability($employee, $date, $time);
            return $employee->id;
        }
        return $this->getRandomAvailableEmployee($service, $date, $time);
    }

    private function checkEmployeeAvailability(User $employee, $date, $time): void
    {
        $appointment = $this->appointmentRepository->isEmployeeAvailable($employee, $date, $time);

        if ($appointment) {
            abort(422, 'Employee already has an appointment at this time.');
        }
    }

    private function getRandomAvailableEmployee(Service $service, $date, $time)
    {
        $employees = $this->userRepository->getEmployeesByService($service);
        $availableSlots = $this->availabilityService->getAvailableSlots($employees, $service, $date);

        $employees = $this->availabilityService->getAvailableEmployees($availableSlots, $time);

        if ($employees->isEmpty()) {
            abort(422, 'No employees available at this time.');
        }

        return $employees->random();
    }
}
