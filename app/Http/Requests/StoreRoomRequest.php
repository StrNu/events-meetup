<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
            'photo_url' => ['nullable', 'string', 'max:255'],
        ];
    }
}
