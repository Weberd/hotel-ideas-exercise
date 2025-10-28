<?php

namespace App\Modules\HuntingTours\Database\Factories;

use App\Modules\HuntingTours\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideFactory extends Factory
{
    protected $model = Guide::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'experience_years' => $this->faker->numberBetween(1, 20),
            'is_active' => true,
        ];
    }
}
