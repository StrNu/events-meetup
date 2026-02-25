<?php

declare(strict_types=1);

namespace App\Domain\Speakers\Actions;

use App\Domain\Speakers\DTOs\SpeakerData;
use App\Domain\Speakers\Models\Speaker;
use App\Domain\Speakers\Repositories\SpeakerRepository;

class CreateSpeaker
{
    public function __construct(private SpeakerRepository $repository) {}

    public function execute(SpeakerData $data): Speaker
    {
        return $this->repository->create($data->toArray());
    }
}
