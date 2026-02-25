<?php

declare(strict_types=1);

namespace App\Domain\Venues\Actions;

use App\Domain\Venues\Models\Room;
use App\Domain\Venues\Repositories\RoomRepository;

class DeleteRoom
{
    public function __construct(private RoomRepository $repository) {}

    public function execute(Room $room): void
    {
        $this->repository->delete($room);
    }
}
