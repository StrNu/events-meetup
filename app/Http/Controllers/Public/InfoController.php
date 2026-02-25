<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Domain\Events\Repositories\EventRepository;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class InfoController extends Controller
{
    public function index(EventRepository $eventRepo): Response
    {
        $event = $eventRepo->getActive();

        return Inertia::render('Info/Index', [
            'event' => $event,
        ]);
    }
}
