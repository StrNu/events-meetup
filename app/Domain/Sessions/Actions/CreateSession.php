<?php

declare(strict_types=1);

namespace App\Domain\Sessions\Actions;

use App\Domain\Sessions\DTOs\SessionData;
use App\Domain\Sessions\Models\Session;
use App\Domain\Sessions\Repositories\SessionRepository;

class CreateSession
{
    public function __construct(private SessionRepository $repository) {}

    public function execute(SessionData $data): Session
    {
        return $this->repository->create($data->toArray());
    }
}
