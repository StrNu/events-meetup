<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Sessions\Repositories\SessionRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ScheduleController extends Controller
{
    public function index(
        Request $request,
        EventRepository $eventRepo,
        SessionRepository $sessionRepo,
    ): Response {
        $event = $eventRepo->getActive();

        $date = $request->query('date', $event?->start_date?->format('Y-m-d') ?? now()->format('Y-m-d'));

        $sessions = [];
        $eventDates = [];

        if ($event) {
            $sessions = $sessionRepo->getByDate($event->id, $date)
                ->load(['speakers', 'room', 'category']);

            $start = $event->start_date->copy();
            $end = $event->end_date->copy();
            while ($start->lte($end)) {
                $eventDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        return Inertia::render('Schedule/Index', [
            'sessions' => $sessions,
            'currentDate' => $date,
            'eventDates' => $eventDates,
        ]);
    }
}
