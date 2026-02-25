<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSpeakerRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'photo_url' => ['nullable', 'string', 'max:255'],
            'social_links' => ['nullable', 'array'],
            'social_links.twitter' => ['nullable', 'url'],
            'social_links.linkedin' => ['nullable', 'url'],
            'social_links.website' => ['nullable', 'url'],
            'type' => ['required', Rule::in(['keynote', 'speaker', 'panelist', 'host'])],
        ];
    }
}
