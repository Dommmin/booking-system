<?php

namespace App\Http\Resources;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Schedule */
class ScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'monday' => ['starts' => $this->monday_starts_at, 'ends' => $this->monday_ends_at],
            'tuesday' => ['starts' => $this->tuesday_starts_at, 'ends' => $this->tuesday_ends_at],
            'wednesday' => ['starts' => $this->wednesday_starts_at, 'ends' => $this->wednesday_ends_at],
            'thursday' => ['starts' => $this->thursday_starts_at, 'ends' => $this->thursday_ends_at],
            'friday' => ['starts' => $this->friday_starts_at, 'ends' => $this->friday_ends_at],
            'saturday' => ['starts' => $this->saturday_starts_at, 'ends' => $this->saturday_ends_at],
            'sunday' => ['starts' => $this->sunday_starts_at, 'ends' => $this->sunday_ends_at],
//            'id' => $this->id,
//            'monday_starts_at' => $this->monday_starts_at,
//            'monday_ends_at' => $this->monday_ends_at,
//            'tuesday_starts_at' => $this->tuesday_starts_at,
//            'tuesday_ends_at' => $this->tuesday_ends_at,
//            'wednesday_starts_at' => $this->wednesday_starts_at,
//            'wednesday_ends_at' => $this->wednesday_ends_at,
//            'thursday_starts_at' => $this->thursday_starts_at,
//            'thursday_ends_at' => $this->thursday_ends_at,
//            'friday_starts_at' => $this->friday_starts_at,
//            'friday_ends_at' => $this->friday_ends_at,
//            'saturday_starts_at' => $this->saturday_starts_at,
//            'saturday_ends_at' => $this->saturday_ends_at,
//            'sunday_starts_at' => $this->sunday_starts_at,
//            'sunday_ends_at' => $this->sunday_ends_at,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//
//            'employee_id' => $this->employee_id,
        ];
    }
}
