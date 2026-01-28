<?php

namespace Database\Factories;

use App\Models\Artist;
use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(fake()->numberBetween(10, 20)),
            'duration' => fake()->numberBetween(10, 300),
        ];
    }

    public function forArtist(Artist $artist): Factory {
        return $this->state(function (array $attributes) use ($artist) {
            return [
                'artist_id' => $artist->id,
            ];
        });
    }
}
