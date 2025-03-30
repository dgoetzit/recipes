<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory
{
    public function definition()
    {
        return [
            'step_number' => 1,
            'description' => fake()->text(120),
        ];
    }
}
