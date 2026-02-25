<?php

declare(strict_types=1);

namespace App\Domain\Sessions\DTOs;

class SessionData
{
    public function __construct(
        public readonly int $eventId,
        public readonly ?int $roomId,
        public readonly ?int $categoryId,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $startTime,
        public readonly string $endTime,
        public readonly bool $isFeatured = false,
    ) {}

    public static function from(array $data): self
    {
        return new self(
            eventId: (int) $data['event_id'],
            roomId: isset($data['room_id']) ? (int) $data['room_id'] : null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            title: $data['title'],
            description: $data['description'] ?? null,
            startTime: $data['start_time'],
            endTime: $data['end_time'],
            isFeatured: (bool) ($data['is_featured'] ?? false),
        );
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->eventId,
            'room_id' => $this->roomId,
            'category_id' => $this->categoryId,
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'is_featured' => $this->isFeatured,
        ];
    }
}
