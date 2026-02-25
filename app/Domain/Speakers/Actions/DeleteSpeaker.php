<?php

declare(strict_types=1);

namespace App\Domain\Speakers\Actions;

use App\Domain\Speakers\Models\Speaker;
use App\Domain\Speakers\Repositories\SpeakerRepository;

class DeleteSpeaker
{
    public function __construct(private SpeakerRepository $repository) {}

    public function execute(Speaker $speaker): void
    {
        $this->repository->delete($speaker);
    }
}
