<?php

declare(strict_types=1);

namespace App\Domain\Events\Actions;

use App\Domain\Events\DTOs\EventData;
use App\Domain\Events\Models\Event;
use App\Domain\Events\Repositories\EventRepository;

class CreateEvent
{
    public function __construct(private EventRepository $repository) {}

    public function execute(EventData $data): Event
    {
        return $this->repository->create($data->toArray());
    }
}
