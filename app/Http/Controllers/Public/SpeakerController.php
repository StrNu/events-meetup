<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Speakers\Repositories\SpeakerRepository;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SpeakerController extends Controller
{
    public function index(EventRepository $eventRepo, SpeakerRepository $speakerRepo): Response
    {
        $event = $eventRepo->getActive();

        return Inertia::render('Speakers/Index', [
            'speakers' => $event ? $speakerRepo->getByEvent($event->id) : [],
        ]);
    }

    public function show(int $id, SpeakerRepository $speakerRepo): Response
    {
        $speaker = $speakerRepo->findByIdOrFail($id);
        $speaker->load('sessions.room');

        return Inertia::render('Speakers/Show', [
            'speaker' => $speaker,
        ]);
    }
}
