<?php

namespace App\Modules\HuntingTours\Database\Factories;

use App\Modules\HuntingTours\Models\Guide;
use App\Modules\HuntingTours\Models\HuntingBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

class HuntingBookingFactory extends Factory
{
    protected $model = HuntingBooking::class;

    public function definition(): array
    {
        return [
            'tour_name' => $this->faker->randomElement([
                'Медвежья охота',
                'Охота на кабана',
                'Лосиная охота',
                'Охота на оленя',
            ]),
            'hunter_name' => $this->faker->name(),
            'guide_id' => Guide::factory(),
            'date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'participants_count' => $this->faker->numberBetween(1, 10),
        ];
    }
}
