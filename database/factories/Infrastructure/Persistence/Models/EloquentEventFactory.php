<?php

namespace Database\Factories\Infrastructure\Persistence\Models;

use App\Infrastructure\Persistence\Models\EloquentEvent;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Persistence\Models\EloquentEvent>
 */
class EloquentEventFactory extends Factory
{
    private const FORMAT_DATE = 'Y-m-d\TH:i:sP';
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = EloquentEvent::class;
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('now', '+2 days')->format(self::FORMAT_DATE);
        $end = fake()->dateTimeBetween($start, '+7 days')->format(self::FORMAT_DATE);
        return [
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'start' => $start,
            'end' => $end,
            'frequency' => fake()->randomElement(['daily', 'weekly', 'monthly', 'yearly']),
            'repeat_until' => fake()->dateTimeBetween($end, '+60 days')->format(self::FORMAT_DATE),
        ];
    }
}
