<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Events\Repositories\EventRepository;
use App\Domain\Venues\Actions\CreateRoom;
use App\Domain\Venues\Actions\DeleteRoom;
use App\Domain\Venues\Actions\UpdateRoom;
use App\Domain\Venues\DTOs\RoomData;
use App\Domain\Venues\Repositories\RoomRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
    public function index(RoomRepository $repository, EventRepository $eventRepo): Response
    {
        $event = $eventRepo->getActive();

        return Inertia::render('Admin/Rooms/Index', [
            'rooms' => $event ? $repository->getWithSessionCount($event->id) : [],
            'event' => $event,
        ]);
    }

    public function create(EventRepository $eventRepo): Response
    {
        return Inertia::render('Admin/Rooms/Create', [
            'event' => $eventRepo->getActive(),
        ]);
    }

    public function store(StoreRoomRequest $request, CreateRoom $action): RedirectResponse
    {
        $action->execute(RoomData::from($request->validated()));

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Sala creada exitosamente.');
    }

    public function edit(int $id, RoomRepository $repository, EventRepository $eventRepo): Response
    {
        return Inertia::render('Admin/Rooms/Edit', [
            'room' => $repository->findByIdOrFail($id),
            'event' => $eventRepo->getActive(),
        ]);
    }

    public function update(StoreRoomRequest $request, int $id, UpdateRoom $action, RoomRepository $repository): RedirectResponse
    {
        $room = $repository->findByIdOrFail($id);
        $action->execute($room, RoomData::from($request->validated()));

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Sala actualizada exitosamente.');
    }

    public function destroy(int $id, DeleteRoom $action, RoomRepository $repository): RedirectResponse
    {
        $room = $repository->findByIdOrFail($id);
        $action->execute($room);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Sala eliminada exitosamente.');
    }
}
