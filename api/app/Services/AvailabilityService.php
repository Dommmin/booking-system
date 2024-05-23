<?php

namespace App\Services;

use App\Models\Service;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

readonly class AvailabilityService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * @param  Collection  $employees
     * @param  Service  $service
     * @param  Carbon  $date
     *
     * @return array
     */
    public function getAvailableSlots(Collection $employees, Service $service, Carbon $date): array
    {
        $dayOfWeek = $date->englishDayOfWeek;

        $columnStart = lcfirst($dayOfWeek) . '_starts_at';
        $columnEnd = lcfirst($dayOfWeek) . '_ends_at';

        $availableSlots = [];

        foreach ($employees as $user) {
            $schedule = $this->userRepository->getUserSchedule($user, [$columnStart, $columnEnd]);

            $start = Carbon::parse($schedule->$columnStart);
            $end = Carbon::parse($schedule->$columnEnd);

            $allAvailableHours = $this->getAllAvailableHours($start, $service, $end);

            $workBreaks = $this->userRepository->getEmployeeWorkBreaksByDate($user, $date)
                ->map(fn ($break) => ['starts_at_time' => $break->starts_at_time, 'ends_at_time' => $break->ends_at_time]);

            $appointments = $this->userRepository->getEmployeeServiceAppointmentsByDate($user, $date)
                ->map(fn ($appointment) => [
                    'starts_at_time' => $appointment->starts_at_time,
                    'ends_at_time' => Carbon::createFromFormat('H:i:s', $appointment->starts_at_time)
                        ->addMinutes($service->duration)->format('H:i:s'),
                ]);

            $breaks = $workBreaks->concat($appointments);

            $availableSlots[$user->id] = $this->getAvailableHours($allAvailableHours, $breaks, $service)->toArray();
        }

        return $availableSlots;
    }

    public function getAvailableEmployees(array $availableSlots, Carbon $time)
    {
        $formattedTime = $time->format('H:i');

        return collect($availableSlots)
            ->filter(fn ($slots) => collect($slots)->contains($formattedTime))
            ->keys();
    }

    public function transform(array $availableSlots): array
    {
        return collect($availableSlots)
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * @param  Carbon  $start
     * @param  Service  $service
     * @param  Carbon  $end
     *
     * @return Collection
     */
    private function getAllAvailableHours(Carbon $start, Service $service, Carbon $end): Collection
    {
        $availableHours = collect();

        while ($start->addMinutes($service->duration)->lte($end)) {
            $availableHours->push($start->subMinutes($service->duration)->format('H:i'));
            $start->addMinutes($service->duration);
        }

        return $availableHours;
    }

    /**
     * @param  Collection  $allAvailableHours
     * @param  Collection  $breaks
     * @param  Service  $service
     *
     * @return Collection
     */
    private function getAvailableHours(Collection $allAvailableHours, Collection $breaks, Service $service): Collection
    {
        return $allAvailableHours->filter(function ($hour) use ($breaks, $service) {
            $hourStart = Carbon::createFromFormat('H:i', $hour);
            $hourEnd = $hourStart->copy()->addMinutes($service->duration);

            return ! $breaks->contains(function ($break) use ($hourStart, $hourEnd) {
                $breakStart = Carbon::createFromFormat('H:i:s', $break['starts_at_time']);
                $breakEnd = Carbon::createFromFormat('H:i:s', $break['ends_at_time']);

                return $hourEnd->gt($breakStart) && $hourStart->lt($breakEnd);
            });
        })->values();
    }
}
