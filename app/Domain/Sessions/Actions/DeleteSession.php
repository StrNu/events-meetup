<?php

declare(strict_types=1);

namespace App\Domain\Sessions\Actions;

use App\Domain\Sessions\Models\Session;
use App\Domain\Sessions\Repositories\SessionRepository;

class DeleteSession
{
    public function __construct(private SessionRepository $repository) {}

    public function execute(Session $session): void
    {
        $this->repository->delete($session);
    }
}
