<?php

declare(strict_types=1);

namespace App\Domain\Events\DTOs;

class EventData
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $startDate,
        public readonly string $endDate,
        public readonly string $location,
        public readonly ?string $contactPhone,
        public readonly ?string $contactEmail,
        public readonly ?string $twitterUrl,
        public readonly ?string $logoUrl,
    ) {}

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            startDate: $data['start_date'],
            endDate: $data['end_date'],
            location: $data['location'],
            contactPhone: $data['contact_phone'] ?? null,
            contactEmail: $data['contact_email'] ?? null,
            twitterUrl: $data['twitter_url'] ?? null,
            logoUrl: $data['logo_url'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'location' => $this->location,
            'contact_phone' => $this->contactPhone,
            'contact_email' => $this->contactEmail,
            'twitter_url' => $this->twitterUrl,
            'logo_url' => $this->logoUrl,
        ];
    }
}
