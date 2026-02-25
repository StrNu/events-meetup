<?php

declare(strict_types=1);

namespace Tests\Feature\Public;

use App\Domain\Categories\Models\Category;
use App\Domain\Events\Models\Event;
use App\Domain\Sessions\Models\Session;
use App\Domain\Speakers\Models\Speaker;
use App\Domain\Venues\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        Event::create([
            'name' => 'Test Event',
            'description' => 'A test event',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addDays(8)->format('Y-m-d'),
            'location' => 'Test Location',
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertInertia(fn ($page) =>
            $page->component('Home')
                ->has('event')
        );
    }

    public function test_home_page_loads_without_event(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertInertia(fn ($page) =>
            $page->component('Home')
                ->where('event', null)
        );
    }

    public function test_home_shows_speakers_and_sessions(): void
    {
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

        Speaker::create([
            'event_id' => $event->id,
            'name' => 'Jane Doe',
            'title' => 'Developer',
            'type' => 'keynote',
        ]);

        Category::create([
            'event_id' => $event->id,
            'name' => 'Development',
        ]);

        Session::create([
            'event_id' => $event->id,
            'room_id' => $room->id,
            'title' => 'Test Talk',
            'start_time' => now()->addDays(7)->setTime(10, 0)->format('Y-m-d H:i:s'),
            'end_time' => now()->addDays(7)->setTime(11, 0)->format('Y-m-d H:i:s'),
            'is_featured' => false,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertInertia(fn ($page) =>
            $page->component('Home')
                ->has('speakers', 1)
                ->has('upcomingSessions', 1)
                ->has('categories', 1)
                ->has('rooms', 1)
        );
    }
}
