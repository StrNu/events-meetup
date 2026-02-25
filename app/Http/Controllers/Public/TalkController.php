<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Sessions\Repositories\SessionRepository;
use App\Domain\Venues\Repositories\RoomRepository;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class TalkController extends Controller
{
    public function index(
        EventRepository $eventRepo,
        SessionRepository $sessionRepo,
        RoomRepository $roomRepo,
    ): Response {
        $event = $eventRepo->getActive();

        $sessionsByRoom = [];
        if ($event) {
            $rooms = $roomRepo->getByEvent($event->id);
            foreach ($rooms as $room) {
                $sessions = $sessionRepo->getByRoom($room->id)->load(['speakers', 'category']);
                if ($sessions->isNotEmpty()) {
                    $sessionsByRoom[] = [
                        'room' => $room,
                        'sessions' => $sessions,
                    ];
                }
            }

            // Sessions without room
            $noRoom = $sessionRepo->getByEvent($event->id)
                ->whereNull('room_id')
                ->load(['speakers', 'category']);
            if ($noRoom->isNotEmpty()) {
                $sessionsByRoom[] = [
                    'room' => ['id' => null, 'name' => 'Sin sala asignada'],
                    'sessions' => $noRoom->values(),
                ];
            }
        }

        return Inertia::render('Talks/Index', [
            'sessionsByRoom' => $sessionsByRoom,
        ]);
    }

    public function show(int $id, SessionRepository $sessionRepo): Response
    {
        $session = $sessionRepo->findByIdOrFail($id);
        $session->load(['speakers', 'room', 'category']);

        return Inertia::render('Talks/Show', [
            'session' => $session,
        ]);
    }
}
