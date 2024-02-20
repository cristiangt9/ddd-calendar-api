<?php

namespace Tests\Feature\Event;

use App\Infrastructure\Persistence\Models\EloquentEvent;
use Carbon\Carbon;
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

    public function test_validate_event_creation_successfully()
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

    public function test_validate_event_creation_and_fails()
    {
        // Intenta crear un evento sin proporcionar datos válidos
        $start = fake()->dateTimeBetween('now', '+7 days')->format(self::FORMAT_DATE);
        $end = fake()->dateTimeBetween($start, '+30 days')->format(self::FORMAT_DATE);
        $response = $this->post('/api/v1/events', [
            // Proporciona datos incorrectos o incompletos aquí
            'title' => fake()->sentence,
            'description' => 1,
            'start' => $start,
            'end' => $end,
            'recurring_pattern' => [
                'frequency' => fake()->randomElement(['daily', 'weekly', 'monthly', 'yearly']),
                'repeat_until' => fake()->dateTimeBetween($end, '+365 days')->format(self::FORMAT_DATE),
            ],
        ]);
        // Verifica que la respuesta contiene un mensaje de error o redirección, según tu implementación
        $response->assertStatus(422); // El código 422 indica errores de validación
    }

    public function test_validate_event_creation_and_successfully_with_recurring()
    {
        // Intenta crear un evento sin proporcionar datos válidos
        $start = fake()->dateTimeBetween('now', '+1 days')->format(self::FORMAT_DATE);
        $end = fake()->dateTimeBetween($start, '+2 days')->format(self::FORMAT_DATE);
        $response = $this->post('/api/v1/events', [
            'title' => fake()->sentence,
            'description' => "",
            'start' => $start,
            'end' => $end,
            'recurring_pattern' => [
                'frequency' => 'weekly',
                'repeat_until' => fake()->dateTimeBetween($end, '+100 days')->format(self::FORMAT_DATE),
            ],
        ]);

        
        $response->assertStatus(201);
        $this->assertDatabaseHas('events', ['id' => $response->json('event')['id']]);
        $this->assertDatabaseHas('events', ['original_event_id' => $response->json('event')['id']]);
    }

    public function test_create_event_fails_by_overlap()
    {
        $event = EloquentEvent::factory()->create();

        // asserts
        $this->assertInstanceOf(EloquentEvent::class, $event);
        $this->assertDatabaseHas('events', ['title' => $event->title]);

        $response = $this->post('/api/v1/events', [
            'title' => $event->title,
            'description' => $event->description,
            'start' => $event->start,
            'end' => $event->end
        ]);

        $response->assertStatus(422);
    }

    public function test_get_all_events()
    {
        $events = EloquentEvent::factory(10)->create();

        $response = $this->get("/api/v1/events");

        $response->assertStatus(200);
        $this->assertCount(
            count($events),
            $response->json('events')
        );
        $response->assertJsonFragment([
            'id' => $events[0]->id,
            'title' => $events[0]->title,
        ]);
    }

    public function test_get_all_events_between_start_and_end()
    {
        $start = fake()->dateTimeBetween('now', '2 days')->format(self::FORMAT_DATE);
        $end = fake()->dateTimeBetween($start, '2 days')->format(self::FORMAT_DATE);
        $event1 = EloquentEvent::factory()->create([
            'title' => fake()->sentence,
            'description' => "",
            'start' => $start,
            'end' => $end,
        ]);
        $start = Carbon::parse($event1->start)->addDays(1)->format(self::FORMAT_DATE);
        $end = Carbon::parse($event1->end)->addDays(1)->format(self::FORMAT_DATE);
        $event2 = EloquentEvent::factory()->create([
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'start' => $start,
            'end' => $end
            
        ]);
        $start = Carbon::parse($event1->start)->addMinutes(-1)->format(self::FORMAT_DATE);
        $end = Carbon::parse($event1->end)->addMinutes(1)->format(self::FORMAT_DATE);
        $response = $this->get("/api/v1/events?start=$start&end=$end");
        $response->assertStatus(200);
        $this->assertCount(
            1,
            $response->json('events')
        );
        $response->assertJsonFragment([
            'id' => $event1->id,
            'title' => $event1->title,
        ]);
    }
}
