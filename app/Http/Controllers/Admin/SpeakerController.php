<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Speakers\Actions\CreateSpeaker;
use App\Domain\Speakers\Actions\DeleteSpeaker;
use App\Domain\Speakers\Actions\UpdateSpeaker;
use App\Domain\Speakers\DTOs\SpeakerData;
use App\Domain\Speakers\Repositories\SpeakerRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpeakerRequest;
use App\Http\Requests\UpdateSpeakerRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SpeakerController extends Controller
{
    public function index(SpeakerRepository $repository, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->getActive();

        return Inertia::render('Admin/Speakers/Index', [
            'speakers' => $event ? $repository->getByEvent($event->id) : [],
            'event' => $event,
        ]);
    }

    public function create(EventRepository $eventRepository): Response
    {
        return Inertia::render('Admin/Speakers/Create', [
            'event' => $eventRepository->getActive(),
        ]);
    }

    public function store(StoreSpeakerRequest $request, CreateSpeaker $action): RedirectResponse
    {
        $action->execute(SpeakerData::from($request->validated()));

        return redirect()->route('admin.speakers.index')
            ->with('success', 'Speaker creado exitosamente.');
    }

    public function edit(int $id, SpeakerRepository $repository, EventRepository $eventRepository): Response
    {
        return Inertia::render('Admin/Speakers/Edit', [
            'speaker' => $repository->findByIdOrFail($id),
            'event' => $eventRepository->getActive(),
        ]);
    }

    public function update(UpdateSpeakerRequest $request, int $id, UpdateSpeaker $action, SpeakerRepository $repository): RedirectResponse
    {
        $speaker = $repository->findByIdOrFail($id);
        $action->execute($speaker, SpeakerData::from($request->validated()));

        return redirect()->route('admin.speakers.index')
            ->with('success', 'Speaker actualizado exitosamente.');
    }

    public function destroy(int $id, DeleteSpeaker $action, SpeakerRepository $repository): RedirectResponse
    {
        $speaker = $repository->findByIdOrFail($id);
        $action->execute($speaker);

        return redirect()->route('admin.speakers.index')
            ->with('success', 'Speaker eliminado exitosamente.');
    }
}
