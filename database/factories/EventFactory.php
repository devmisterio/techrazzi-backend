<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    private static int $eventCount = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 month', '+1 year');
        $hour = $this->faker->randomElement([9, 10, 11]);
        $startDate->setTime($hour, 0);

        $endDate = $this->faker->boolean(80)
            ? clone $startDate
            : (clone $startDate)->modify('+'.rand(1, 2).' days');
        $hour = $this->faker->randomElement([17, 18, 19]);
        $endDate->setTime($hour, 0);

        $isOnline = $this->faker->boolean(30);

        $participantLimit = $this->faker->boolean(35) ? $this->faker->numberBetween(20, 50) : null;

        return [
            'name' => 'Event ' . self::$eventCount++,
            'description' => $this->faker->paragraph(nbSentences: 2, variableNbSentences: true),
            'abstract' => $this->faker->text,
            'list_image' => $this->faker->imageUrl(),
            'banner_image' => $this->faker->imageUrl(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_online' => $isOnline,
            'venue_id' => $isOnline ? null : Venue::factory(),
            'participant_limit' => $participantLimit
        ];
    }
}
