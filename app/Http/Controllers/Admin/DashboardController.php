<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Categories\Repositories\CategoryRepository;
use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Sessions\Repositories\SessionRepository;
use App\Domain\Speakers\Repositories\SpeakerRepository;
use App\Domain\Venues\Repositories\RoomRepository;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(
        EventRepository $eventRepo,
        SpeakerRepository $speakerRepo,
        SessionRepository $sessionRepo,
        RoomRepository $roomRepo,
        CategoryRepository $categoryRepo,
    ): Response {
        $event = $eventRepo->getActive();

        $stats = [
            'speakers' => 0,
            'sessions' => 0,
            'rooms' => 0,
            'categories' => 0,
        ];

        $upcomingSessions = [];

        if ($event) {
            $stats = [
                'speakers' => $speakerRepo->getByEvent($event->id)->count(),
                'sessions' => $sessionRepo->getByEvent($event->id)->count(),
                'rooms' => $roomRepo->getByEvent($event->id)->count(),
                'categories' => $categoryRepo->getByEvent($event->id)->count(),
            ];

            $upcomingSessions = $sessionRepo->getUpcoming($event->id, 5)
                ->load(['room', 'speakers']);
        }

        return Inertia::render('Admin/Dashboard', [
            'event' => $event,
            'stats' => $stats,
            'upcomingSessions' => $upcomingSessions,
        ]);
    }
}
