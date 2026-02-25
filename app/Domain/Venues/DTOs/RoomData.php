<?php

declare(strict_types=1);

namespace App\Domain\Venues\DTOs;

class RoomData
{
    public function __construct(
        public readonly int $eventId,
        public readonly string $name,
        public readonly ?int $capacity,
        public readonly ?string $description,
        public readonly ?string $photoUrl,
    ) {}

    public static function from(array $data): self
    {
        return new self(
            eventId: (int) $data['event_id'],
            name: $data['name'],
            capacity: isset($data['capacity']) ? (int) $data['capacity'] : null,
            description: $data['description'] ?? null,
            photoUrl: $data['photo_url'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->eventId,
            'name' => $this->name,
            'capacity' => $this->capacity,
            'description' => $this->description,
            'photo_url' => $this->photoUrl,
        ];
    }
}
