<?php

declare(strict_types=1);

namespace App\Domain\Speakers\DTOs;

class SpeakerData
{
    public function __construct(
        public readonly int $eventId,
        public readonly string $name,
        public readonly string $title,
        public readonly ?string $organization,
        public readonly ?string $bio,
        public readonly ?string $photoUrl,
        public readonly ?array $socialLinks,
        public readonly string $type = 'speaker',
    ) {}

    public static function from(array $data): self
    {
        return new self(
            eventId: (int) $data['event_id'],
            name: $data['name'],
            title: $data['title'],
            organization: $data['organization'] ?? null,
            bio: $data['bio'] ?? null,
            photoUrl: $data['photo_url'] ?? null,
            socialLinks: $data['social_links'] ?? null,
            type: $data['type'] ?? 'speaker',
        );
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->eventId,
            'name' => $this->name,
            'title' => $this->title,
            'organization' => $this->organization,
            'bio' => $this->bio,
            'photo_url' => $this->photoUrl,
            'social_links' => $this->socialLinks,
            'type' => $this->type,
        ];
    }
}
