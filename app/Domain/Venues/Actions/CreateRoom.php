<?php

declare(strict_types=1);

namespace App\Domain\Venues\Actions;

use App\Domain\Venues\DTOs\RoomData;
use App\Domain\Venues\Models\Room;
use App\Domain\Venues\Repositories\RoomRepository;

class CreateRoom
{
    public function __construct(private RoomRepository $repository) {}

    public function execute(RoomData $data): Room
    {
        return $this->repository->create($data->toArray());
    }
}
