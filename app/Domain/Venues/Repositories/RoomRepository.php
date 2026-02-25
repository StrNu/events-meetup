<?php

declare(strict_types=1);

namespace App\Domain\Venues\Repositories;

use App\Domain\Venues\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository
{
    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function findById(int $id): ?Room
    {
        return Room::find($id);
    }

    public function findByIdOrFail(int $id): Room
    {
        return Room::findOrFail($id);
    }

    public function update(Room $room, array $data): Room
    {
        $room->update($data);
        return $room->refresh();
    }

    public function delete(Room $room): void
    {
        $room->delete();
    }

    public function getByEvent(int $eventId): Collection
    {
        return Room::where('event_id', $eventId)->get();
    }

    public function getWithSessionCount(int $eventId): Collection
    {
        return Room::where('event_id', $eventId)
            ->withCount('sessions')
            ->get();
    }
}
