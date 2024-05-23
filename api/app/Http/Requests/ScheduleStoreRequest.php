<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'monday_starts_at' => ['nullable', 'date_format:H:i:s'],
            'monday_ends_at' => ['nullable', 'date_format:H:i:s', 'required_with:monday_starts_at'],
            'tuesday_starts_at' => ['nullable', 'date_format:H:i:s'],
            'tuesday_ends_at' => ['nullable', 'date_format:H:i:s', 'required_with:tuesday_starts_at'],
            'wednesday_starts_at' => ['nullable', 'date_format:H:i:s'],
            'wednesday_ends_at' => ['nullable', 'date_format:H:i:s', 'required_with:wednesday_starts_at'],
            'thursday_starts_at' => ['nullable', 'date_format:H:i:s'],
            'thursday_ends_at' => ['nullable', 'date_format:H:i:s', 'required_with:thursday_starts_at'],
            'friday_starts_at' => ['nullable', 'date_format:H:i:s'],
            'friday_ends_at' => ['nullable', 'date_format:H:i:s', 'required_with:friday_starts_at'],
            'saturday_starts_at' => ['nullable', 'date_format:H:i:s'],
            'saturday_ends_at' => ['nullable', 'date_format:H:i:s', 'required_with:saturday_starts_at'],
            'sunday_starts_at' => ['nullable', 'date_format:H:i:s'],
            'sunday_ends_at' => ['nullable', 'date_format:H:i:s', 'required_with:sunday_starts_at'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
