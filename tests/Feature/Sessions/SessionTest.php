<?php

declare(strict_types=1);

namespace Tests\Feature\Sessions;

use App\Domain\Categories\Models\Category;
use App\Domain\Events\Models\Event;
use App\Domain\Speakers\Models\Speaker;
use App\Domain\Users\Models\User;
use App\Domain\Venues\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Event $event;
    private Room $room;
    private Category $category;
    private Speaker $speaker;

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

        $this->room = Room::create([
            'event_id' => $this->event->id,
            'name' => 'Main Room',
            'capacity' => 100,
        ]);

        $this->category = Category::create([
            'event_id' => $this->event->id,
            'name' => 'Development',
        ]);

        $this->speaker = Speaker::create([
            'event_id' => $this->event->id,
            'name' => 'John Doe',
            'title' => 'Developer',
            'type' => 'speaker',
        ]);
    }

    public function test_can_create_session(): void
    {
        $startTime = now()->addDays(7)->setTime(10, 0);
        $endTime = now()->addDays(7)->setTime(11, 0);

        $response = $this->actingAs($this->user)->post(route('admin.sessions.store'), [
            'event_id' => $this->event->id,
            'room_id' => $this->room->id,
            'category_id' => $this->category->id,
            'title' => 'Test Session',
            'description' => 'A test session',
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s'),
            'is_featured' => false,
        ]);

        $response->assertRedirect(route('admin.sessions.index'));
        $this->assertDatabaseHas('sessions', [
            'title' => 'Test Session',
            'event_id' => $this->event->id,
            'room_id' => $this->room->id,
        ]);
    }

    public function test_can_create_session_with_speakers(): void
    {
        $startTime = now()->addDays(7)->setTime(10, 0);
        $endTime = now()->addDays(7)->setTime(11, 0);

        $response = $this->actingAs($this->user)->post(route('admin.sessions.store'), [
            'event_id' => $this->event->id,
            'room_id' => $this->room->id,
            'category_id' => $this->category->id,
            'title' => 'Session with Speaker',
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s'),
            'is_featured' => false,
            'speakers' => [
                ['id' => $this->speaker->id, 'role' => 'main'],
            ],
        ]);

        $response->assertRedirect(route('admin.sessions.index'));
        $this->assertDatabaseHas('session_speaker', [
            'speaker_id' => $this->speaker->id,
            'role' => 'main',
        ]);
    }

    public function test_end_time_must_be_after_start_time(): void
    {
        $startTime = now()->addDays(7)->setTime(11, 0);
        $endTime = now()->addDays(7)->setTime(10, 0);

        $response = $this->actingAs($this->user)->post(route('admin.sessions.store'), [
            'event_id' => $this->event->id,
            'title' => 'Invalid Session',
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors(['end_time']);
    }

    public function test_title_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('admin.sessions.store'), [
            'event_id' => $this->event->id,
            'start_time' => now()->addDays(7)->format('Y-m-d H:i:s'),
            'end_time' => now()->addDays(7)->addHour()->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors(['title']);
    }
}
