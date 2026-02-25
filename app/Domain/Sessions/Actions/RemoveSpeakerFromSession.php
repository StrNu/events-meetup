<?php

declare(strict_types=1);

namespace App\Domain\Sessions\Actions;

use App\Domain\Sessions\Models\Session;

class RemoveSpeakerFromSession
{
    public function execute(Session $session, int $speakerId): void
    {
        $session->speakers()->detach($speakerId);
    }
}
