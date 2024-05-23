<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'monday_starts_at' => '09:00:00',
            'monday_ends_at' => '17:00:00',
            'tuesday_starts_at' => '09:00:00',
            'tuesday_ends_at' => '17:00:00',
            'wednesday_starts_at' => '9:00:00',
            'wednesday_ends_at' => '17:00:00',
            'thursday_starts_at' => '9:00:00',
            'thursday_ends_at' => '17:00:00',
            'friday_starts_at' => '9:00:00',
            'friday_ends_at' => '17:00:00',
            'saturday_starts_at' => '9:00:00',
            'saturday_ends_at' => '17:00:00',
            'sunday_starts_at' => '9:00:00',
            'sunday_ends_at' => '17:00:00',

            'employee_id' => User::factory()->create()->id,
        ];
    }
}
