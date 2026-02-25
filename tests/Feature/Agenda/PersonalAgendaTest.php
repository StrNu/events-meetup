<?php

declare(strict_types=1);

namespace Tests\Feature\Agenda;

use App\Domain\Events\Models\Event;
use App\Domain\Sessions\Models\Session;
use App\Domain\Users\Models\User;
use App\Domain\Venues\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonalAgendaTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Session $session;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        $event = Event::create([
            'name' => 'Test Event',
            'description' => 'A test event',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addDays(8)->format('Y-m-d'),
            'location' => 'Test Location',
        ]);

        $room = Room::create([
            'event_id' => $event->id,
            'name' => 'Room 1',
            'capacity' => 50,
        ]);

        $this->session = Session::create([
            'event_id' => $event->id,
            'room_id' => $room->id,
            'title' => 'Test Session',
            'start_time' => now()->addDays(7)->setTime(10, 0)->format('Y-m-d H:i:s'),
            'end_time' => now()->addDays(7)->setTime(11, 0)->format('Y-m-d H:i:s'),
            'is_featured' => false,
        ]);
    }

    public function test_authenticated_user_can_add_session_to_agenda(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('my-talks.store', $this->session->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('user_sessions', [
            'user_id' => $this->user->id,
            'session_id' => $this->session->id,
        ]);
    }

    public function test_authenticated_user_can_remove_session_from_agenda(): void
    {
        $this->user->savedSessions()->attach($this->session->id);

        $response = $this->actingAs($this->user)
            ->delete(route('my-talks.destroy', $this->session->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('user_sessions', [
            'user_id' => $this->user->id,
            'session_id' => $this->session->id,
        ]);
    }

    public function test_adding_duplicate_session_does_not_create_duplicate(): void
    {
        $this->user->savedSessions()->attach($this->session->id);

        $this->actingAs($this->user)
            ->post(route('my-talks.store', $this->session->id));

        $this->assertCount(1, $this->user->savedSessions);
    }

    public function test_unauthenticated_user_cannot_add_to_agenda(): void
    {
        $response = $this->post(route('my-talks.store', $this->session->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('user_sessions', [
            'session_id' => $this->session->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_remove_from_agenda(): void
    {
        $response = $this->delete(route('my-talks.destroy', $this->session->id));

        $response->assertRedirect();
    }

    public function test_my_talks_index_shows_saved_sessions(): void
    {
        $this->user->savedSessions()->attach($this->session->id);

        $response = $this->actingAs($this->user)
            ->get(route('my-talks.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) =>
            $page->component('MyTalks/Index')
                ->has('sessions', 1)
        );
    }
}
