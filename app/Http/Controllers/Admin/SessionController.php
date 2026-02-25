<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Categories\Repositories\CategoryRepository;
use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Sessions\Actions\CreateSession;
use App\Domain\Sessions\Actions\DeleteSession;
use App\Domain\Sessions\Actions\UpdateSession;
use App\Domain\Sessions\DTOs\SessionData;
use App\Domain\Sessions\Repositories\SessionRepository;
use App\Domain\Speakers\Repositories\SpeakerRepository;
use App\Domain\Venues\Repositories\RoomRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Requests\UpdateSessionRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SessionController extends Controller
{
    public function index(
        SessionRepository $sessionRepo,
        EventRepository $eventRepo,
    ): Response {
        $event = $eventRepo->getActive();

        return Inertia::render('Admin/Sessions/Index', [
            'sessions' => $event
                ? $sessionRepo->getByEvent($event->id)->load(['room', 'category', 'speakers'])
                : [],
            'event' => $event,
        ]);
    }

    public function create(
        EventRepository $eventRepo,
        RoomRepository $roomRepo,
        CategoryRepository $categoryRepo,
        SpeakerRepository $speakerRepo,
    ): Response {
        $event = $eventRepo->getActive();

        return Inertia::render('Admin/Sessions/Create', [
            'event' => $event,
            'rooms' => $event ? $roomRepo->getByEvent($event->id) : [],
            'categories' => $event ? $categoryRepo->getByEvent($event->id) : [],
            'speakers' => $event ? $speakerRepo->getByEvent($event->id) : [],
        ]);
    }

    public function store(StoreSessionRequest $request, CreateSession $action): RedirectResponse
    {
        $validated = $request->validated();
        $session = $action->execute(SessionData::from($validated));

        if (!empty($validated['speakers'])) {
            $pivotData = collect($validated['speakers'])->mapWithKeys(fn ($s) => [
                $s['id'] => ['role' => $s['role']],
            ])->all();
            $session->speakers()->sync($pivotData);
        }

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Sesion creada exitosamente.');
    }

    public function edit(
        int $id,
        SessionRepository $sessionRepo,
        EventRepository $eventRepo,
        RoomRepository $roomRepo,
        CategoryRepository $categoryRepo,
        SpeakerRepository $speakerRepo,
    ): Response {
        $event = $eventRepo->getActive();
        $session = $sessionRepo->findByIdOrFail($id);
        $session->load('speakers');

        return Inertia::render('Admin/Sessions/Edit', [
            'session' => $session,
            'event' => $event,
            'rooms' => $event ? $roomRepo->getByEvent($event->id) : [],
            'categories' => $event ? $categoryRepo->getByEvent($event->id) : [],
            'speakers' => $event ? $speakerRepo->getByEvent($event->id) : [],
        ]);
    }

    public function update(
        UpdateSessionRequest $request,
        int $id,
        UpdateSession $action,
        SessionRepository $sessionRepo,
    ): RedirectResponse {
        $validated = $request->validated();
        $session = $sessionRepo->findByIdOrFail($id);
        $action->execute($session, SessionData::from($validated));

        $pivotData = collect($validated['speakers'] ?? [])->mapWithKeys(fn ($s) => [
            $s['id'] => ['role' => $s['role']],
        ])->all();
        $session->speakers()->sync($pivotData);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Sesion actualizada exitosamente.');
    }

    public function destroy(int $id, DeleteSession $action, SessionRepository $sessionRepo): RedirectResponse
    {
        $session = $sessionRepo->findByIdOrFail($id);
        $action->execute($session);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Sesion eliminada exitosamente.');
    }
}
