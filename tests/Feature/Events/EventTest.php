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
    /**
     * A basic feature test example.
     */
    public function test_create_event_by_factory()
    {
        
        $event = EloquentEvent::factory()->create();
        
        // assertions
        $this->assertInstanceOf(EloquentEvent::class, $event);
        $this->assertDatabaseHas('events', ['title' => $event->title]);
    }
}
