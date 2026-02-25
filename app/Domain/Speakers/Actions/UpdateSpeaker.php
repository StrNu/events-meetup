<?php

declare(strict_types=1);

namespace App\Domain\Speakers\Actions;

use App\Domain\Speakers\DTOs\SpeakerData;
use App\Domain\Speakers\Models\Speaker;
use App\Domain\Speakers\Repositories\SpeakerRepository;

class UpdateSpeaker
{
    public function __construct(private SpeakerRepository $repository) {}

    public function execute(Speaker $speaker, SpeakerData $data): Speaker
    {
        return $this->repository->update($speaker, $data->toArray());
    }
}
