<?php

declare(strict_types=1);

namespace App\Domain\Sessions\Repositories;

use App\Domain\Sessions\Models\Session;
use Illuminate\Database\Eloquent\Collection;

class SessionRepository
{
    public function create(array $data): Session
    {
        return Session::create($data);
    }

    public function findById(int $id): ?Session
    {
        return Session::find($id);
    }

    public function findByIdOrFail(int $id): Session
    {
        return Session::findOrFail($id);
    }

    public function update(Session $session, array $data): Session
    {
        $session->update($data);
        return $session->refresh();
    }

    public function delete(Session $session): void
    {
        $session->delete();
    }

    public function getByEvent(int $eventId): Collection
    {
        return Session::where('event_id', $eventId)
            ->orderBy('start_time')
            ->get();
    }

    public function getByRoom(int $roomId): Collection
    {
        return Session::where('room_id', $roomId)
            ->orderBy('start_time')
            ->get();
    }

    public function getByCategory(int $categoryId): Collection
    {
        return Session::where('category_id', $categoryId)
            ->orderBy('start_time')
            ->get();
    }

    public function getUpcoming(int $eventId, int $limit = 10): Collection
    {
        return Session::where('event_id', $eventId)
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->limit($limit)
            ->get();
    }

    public function getFeatured(int $eventId): Collection
    {
        return Session::where('event_id', $eventId)
            ->where('is_featured', true)
            ->orderBy('start_time')
            ->get();
    }

    public function getByDate(int $eventId, string $date): Collection
    {
        return Session::where('event_id', $eventId)
            ->whereDate('start_time', $date)
            ->orderBy('start_time')
            ->get();
    }
}
