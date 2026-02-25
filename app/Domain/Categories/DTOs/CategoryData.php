<?php

declare(strict_types=1);

namespace App\Domain\Categories\DTOs;

class CategoryData
{
    public function __construct(
        public readonly int $eventId,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $imageUrl,
    ) {}

    public static function from(array $data): self
    {
        return new self(
            eventId: (int) $data['event_id'],
            name: $data['name'],
            description: $data['description'] ?? null,
            imageUrl: $data['image_url'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->eventId,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->imageUrl,
        ];
    }
}
