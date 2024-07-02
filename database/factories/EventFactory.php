<?php

namespace Database\Factories;

use Alirezasedghi\LaravelImageFaker\ImageFaker;
use Alirezasedghi\LaravelImageFaker\Services\LoremFlickr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $end_date = $this->faker->dateTimeBetween($start_date, $start_date->format('Y-m-d H:i:s').' +2 days');

        $imageFaker = new ImageFaker(new LoremFlickr());

        return [
            'title' => $this->faker->sentence(),
            'image' => $imageFaker->image(storage_path('app/public/images/events'),640,480,false,false,true),
            'description' => $this->faker->realText,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => 1,
        ];
    }
}
