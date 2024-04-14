<?php

namespace Database\Factories;

use App\Models\Speaker;
use App\Models\Talk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Speaker>
 */
class SpeakerFactory extends Factory
{
    protected $model = Speaker::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $socialMediaOptions = [
            'twitter' => 'https://twitter.com/' . $this->faker->userName,
            'linkedin' => 'https://linkedin.com/in/' . $this->faker->userName,
            'facebook' => 'https://facebook.com/' . $this->faker->userName,
        ];

        $socialMedia = $this->faker->randomElements(
            array_keys($socialMediaOptions),
            rand(0, count($socialMediaOptions))
        );

        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'resume' => $this->faker->paragraph,
            'title' => $this->faker->jobTitle,
            'company' => $this->faker->company,
            'image_url' => $this->faker->imageUrl(640, 480, 'people'),
            'social_media' => array_intersect_key($socialMediaOptions, array_flip($socialMedia)),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Speaker $speaker) {
            $talks = Talk::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($talks as $talk) {
                $speaker->talks()->attach($talk->id);
            }
        });
    }
}
