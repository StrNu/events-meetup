<?php

declare(strict_types=1);

namespace App\Domain\Events\Repositories;

use App\Domain\Events\Models\Event;
use Illuminate\Database\Eloquent\Collection;

class EventRepository
{
    public function create(array $data): Event
    {
        return Event::create($data);
    }

    public function findById(int $id): ?Event
    {
        return Event::find($id);
    }

    public function findByIdOrFail(int $id): Event
    {
        return Event::findOrFail($id);
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);
        return $event->refresh();
    }

    public function delete(Event $event): void
    {
        $event->delete();
    }

    public function getAll(): Collection
    {
        return Event::all();
    }

    public function getActive(): ?Event
    {
        return Event::latest('start_date')->first();
    }
}
