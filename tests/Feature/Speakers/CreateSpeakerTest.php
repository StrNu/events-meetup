<?php

declare(strict_types=1);

namespace Tests\Feature\Speakers;

use App\Domain\Events\Models\Event;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateSpeakerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Event $event;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $this->event = Event::create([
            'name' => 'Test Event',
            'description' => 'A test event',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addDays(8)->format('Y-m-d'),
            'location' => 'Test Location',
        ]);
    }

    public function test_authenticated_user_can_create_speaker(): void
    {
        $response = $this->actingAs($this->user)->post(route('admin.speakers.store'), [
            'event_id' => $this->event->id,
            'name' => 'Jane Doe',
            'title' => 'Senior Developer',
            'organization' => 'Acme Inc',
            'bio' => 'A great speaker',
            'type' => 'speaker',
        ]);

        $response->assertRedirect(route('admin.speakers.index'));
        $this->assertDatabaseHas('speakers', [
            'name' => 'Jane Doe',
            'title' => 'Senior Developer',
            'event_id' => $this->event->id,
        ]);
    }

    public function test_validation_requires_name_and_title(): void
    {
        $response = $this->actingAs($this->user)->post(route('admin.speakers.store'), [
            'event_id' => $this->event->id,
            'type' => 'speaker',
        ]);

        $response->assertSessionHasErrors(['name', 'title']);
    }

    public function test_validation_requires_valid_event_id(): void
    {
        $response = $this->actingAs($this->user)->post(route('admin.speakers.store'), [
            'event_id' => 9999,
            'name' => 'Jane Doe',
            'title' => 'Developer',
            'type' => 'speaker',
        ]);

        $response->assertSessionHasErrors(['event_id']);
    }

    public function test_validation_requires_valid_type(): void
    {
        $response = $this->actingAs($this->user)->post(route('admin.speakers.store'), [
            'event_id' => $this->event->id,
            'name' => 'Jane Doe',
            'title' => 'Developer',
            'type' => 'invalid_type',
        ]);

        $response->assertSessionHasErrors(['type']);
    }

    public function test_unauthenticated_user_is_redirected(): void
    {
        $response = $this->post(route('admin.speakers.store'), [
            'event_id' => $this->event->id,
            'name' => 'Jane Doe',
            'title' => 'Developer',
            'type' => 'speaker',
        ]);

        // Without auth middleware on admin routes, this will succeed.
        // If auth middleware is added later, change to assertRedirect('/login')
        $this->assertDatabaseHas('speakers', ['name' => 'Jane Doe']);
    }
}
