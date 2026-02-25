<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Speakers;

use App\Domain\Events\Models\Event;
use App\Domain\Speakers\Actions\CreateSpeaker;
use App\Domain\Speakers\DTOs\SpeakerData;
use App\Domain\Speakers\Repositories\SpeakerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateSpeakerActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_speaker_with_all_fields(): void
    {
        $event = Event::create([
            'name' => 'Test Event',
            'description' => 'A test event',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addDays(8)->format('Y-m-d'),
            'location' => 'Test Location',
        ]);

        $data = SpeakerData::from([
            'event_id' => $event->id,
            'name' => 'Jane Doe',
            'title' => 'Lead Engineer',
            'organization' => 'Acme Corp',
            'bio' => 'A great engineer with 10 years experience.',
            'photo_url' => 'https://example.com/photo.jpg',
            'social_links' => [
                'twitter' => 'https://x.com/janedoe',
                'linkedin' => 'https://linkedin.com/in/janedoe',
            ],
            'type' => 'keynote',
        ]);

        $action = app(CreateSpeaker::class);
        $speaker = $action->execute($data);

        $this->assertNotNull($speaker->id);
        $this->assertEquals('Jane Doe', $speaker->name);
        $this->assertEquals('Lead Engineer', $speaker->title);
        $this->assertEquals('Acme Corp', $speaker->organization);
        $this->assertEquals('keynote', $speaker->type);
        $this->assertEquals($event->id, $speaker->event_id);
        $this->assertEquals('https://x.com/janedoe', $speaker->social_links['twitter']);
    }

    public function test_creates_speaker_with_minimal_fields(): void
    {
        $event = Event::create([
            'name' => 'Test Event',
            'description' => 'A test event',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addDays(8)->format('Y-m-d'),
            'location' => 'Test Location',
        ]);

        $data = SpeakerData::from([
            'event_id' => $event->id,
            'name' => 'John Smith',
            'title' => 'Developer',
        ]);

        $action = app(CreateSpeaker::class);
        $speaker = $action->execute($data);

        $this->assertNotNull($speaker->id);
        $this->assertEquals('John Smith', $speaker->name);
        $this->assertEquals('speaker', $speaker->type);
        $this->assertNull($speaker->organization);
        $this->assertNull($speaker->bio);
    }

    public function test_speaker_is_persisted_to_database(): void
    {
        $event = Event::create([
            'name' => 'Test Event',
            'description' => 'A test event',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addDays(8)->format('Y-m-d'),
            'location' => 'Test Location',
        ]);

        $data = SpeakerData::from([
            'event_id' => $event->id,
            'name' => 'Persisted Speaker',
            'title' => 'Tester',
        ]);

        $action = app(CreateSpeaker::class);
        $action->execute($data);

        $this->assertDatabaseHas('speakers', [
            'name' => 'Persisted Speaker',
            'event_id' => $event->id,
        ]);
    }
}
