<?php

declare(strict_types=1);

namespace App\Domain\Sessions\Actions;

use App\Domain\Sessions\DTOs\SessionData;
use App\Domain\Sessions\Models\Session;
use App\Domain\Sessions\Repositories\SessionRepository;

class UpdateSession
{
    public function __construct(private SessionRepository $repository) {}

    public function execute(Session $session, SessionData $data): Session
    {
        return $this->repository->update($session, $data->toArray());
    }
}
