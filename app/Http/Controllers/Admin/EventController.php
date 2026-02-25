<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Events\Actions\UpdateEvent;
use App\Domain\Events\DTOs\EventData;
use App\Domain\Events\Repositories\EventRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function edit(EventRepository $repository): Response
    {
        return Inertia::render('Admin/Events/Edit', [
            'event' => $repository->getActive(),
        ]);
    }

    public function update(UpdateEventRequest $request, int $id, UpdateEvent $action, EventRepository $repository): RedirectResponse
    {
        $event = $repository->findByIdOrFail($id);
        $action->execute($event, EventData::from($request->validated()));

        return redirect()->route('admin.events.edit')
            ->with('success', 'Evento actualizado exitosamente.');
    }
}
