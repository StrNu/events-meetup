<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Domain\Categories\Repositories\CategoryRepository;
use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Sessions\Repositories\SessionRepository;
use App\Domain\Speakers\Repositories\SpeakerRepository;
use App\Domain\Venues\Repositories\RoomRepository;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(
        EventRepository $eventRepo,
        SpeakerRepository $speakerRepo,
        SessionRepository $sessionRepo,
        CategoryRepository $categoryRepo,
        RoomRepository $roomRepo,
    ): Response {
        $event = $eventRepo->getActive();

        return Inertia::render('Home', [
            'event' => $event,
            'speakers' => $event ? $speakerRepo->getByEvent($event->id) : [],
            'upcomingSessions' => $event
                ? $sessionRepo->getUpcoming($event->id, 10)->load(['speakers', 'room'])
                : [],
            'categories' => $event ? $categoryRepo->getByEvent($event->id) : [],
            'rooms' => $event ? $roomRepo->getByEvent($event->id) : [],
        ]);
    }
}
