<?php

declare(strict_types=1);

namespace App\Domain\Events\Actions;

use App\Domain\Events\DTOs\EventData;
use App\Domain\Events\Models\Event;
use App\Domain\Events\Repositories\EventRepository;

class UpdateEvent
{
    public function __construct(private EventRepository $repository) {}

    public function execute(Event $event, EventData $data): Event
    {
        return $this->repository->update($event, $data->toArray());
    }
}
