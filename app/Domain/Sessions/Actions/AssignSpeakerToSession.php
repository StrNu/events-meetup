<?php

declare(strict_types=1);

namespace App\Domain\Sessions\Actions;

use App\Domain\Sessions\Models\Session;

class AssignSpeakerToSession
{
    public function execute(Session $session, int $speakerId, string $role = 'main'): void
    {
        $session->speakers()->syncWithoutDetaching([
            $speakerId => ['role' => $role],
        ]);
    }
}
