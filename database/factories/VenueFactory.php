<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venue>
 */
class VenueFactory extends Factory
{
    protected $model = Venue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameSuffix = $this->faker->randomElement(['Hotel', 'Group']);

        $latitude = $this->faker->latitude;
        $longitude = $this->faker->longitude;

        return [
            'name' => $this->faker->company . ' ' . $nameSuffix,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'map_link' => "https://www.google.com/maps/place/{$latitude},{$longitude}"
        ];
    }
}
