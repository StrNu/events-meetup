<?php

declare(strict_types=1);

namespace App\Domain\Speakers\Repositories;

use App\Domain\Speakers\Models\Speaker;
use Illuminate\Database\Eloquent\Collection;

class SpeakerRepository
{
    public function create(array $data): Speaker
    {
        return Speaker::create($data);
    }

    public function findById(int $id): ?Speaker
    {
        return Speaker::find($id);
    }

    public function findByIdOrFail(int $id): Speaker
    {
        return Speaker::findOrFail($id);
    }

    public function update(Speaker $speaker, array $data): Speaker
    {
        $speaker->update($data);
        return $speaker->refresh();
    }

    public function delete(Speaker $speaker): void
    {
        $speaker->delete();
    }

    public function getByEvent(int $eventId): Collection
    {
        return Speaker::where('event_id', $eventId)->get();
    }

    public function search(int $eventId, string $query): Collection
    {
        return Speaker::where('event_id', $eventId)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('title', 'like', "%{$query}%")
                  ->orWhere('organization', 'like', "%{$query}%");
            })
            ->get();
    }

    public function getByType(int $eventId, string $type): Collection
    {
        return Speaker::where('event_id', $eventId)
            ->where('type', $type)
            ->get();
    }
}
