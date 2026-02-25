<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Sessions\Repositories\SessionRepository;
use App\Domain\Venues\Repositories\RoomRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MapController extends Controller
{
    public function index(Request $request, EventRepository $eventRepo, RoomRepository $roomRepo): Response
    {
        $event = $eventRepo->getActive();

        $rooms = $event
            ? $roomRepo->getWithSessionCount($event->id)
            : collect();

        return Inertia::render('Map/Index', [
            'rooms' => $rooms,
        ]);
    }

    public function show(int $id, RoomRepository $roomRepo, SessionRepository $sessionRepo): Response
    {
        $room = $roomRepo->findByIdOrFail($id);

        $sessions = $sessionRepo->getByRoom($room->id)
            ->load(['speakers', 'category']);

        return Inertia::render('Map/Show', [
            'room' => $room,
            'sessions' => $sessions,
        ]);
    }
}
