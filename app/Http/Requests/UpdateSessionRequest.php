<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'room_id' => ['nullable', 'integer', 'exists:rooms,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'is_featured' => ['boolean'],
            'speakers' => ['nullable', 'array'],
            'speakers.*.id' => ['required', 'integer', 'exists:speakers,id'],
            'speakers.*.role' => ['required', 'in:main,co-speaker,moderator'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_time.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
        ];
    }
}
