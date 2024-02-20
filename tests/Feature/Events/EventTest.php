<?php

namespace Tests\Feature\Event;

use App\Infrastructure\Persistence\Models\EloquentEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    private const FORMAT_DATE = 'Y-m-d\TH:i:sP';

    public function test_create_event_by_factory()
    {
        
        $event = EloquentEvent::factory()->create();
        
        // assertions
        $this->assertInstanceOf(EloquentEvent::class, $event);
        $this->assertDatabaseHas('events', ['title' => $event->title]);
    }

    public function test_validate_event_creation_and_creates_event()
    {
        // Intenta crear un evento sin proporcionar datos válidos
        $start = fake()->dateTimeBetween('now', '+7 days')->format(self::FORMAT_DATE);
        $end = fake()->dateTimeBetween($start, '+30 days')->format(self::FORMAT_DATE);
        $response = $this->post('/api/v1/events', [
            'title' => fake()->sentence,
            'description' => "",
            'start' => $start,
            'end' => $end,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('events', ['id' => $response->json('event')['id']]);
    }
}
