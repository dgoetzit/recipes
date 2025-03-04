<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Database\Seeder;

class RecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recipe::factory()->hasAttached(
            Ingredient::factory()->count(rand(4, 10)),
            [
                'measure_amount' => rand(1, 10),
                'measure_unit' => fake()->randomElement(['oz', 'lbs', 'tsp', 'tbsp']),
            ]
        )
            ->has(Step::factory()->count(rand(6, 10)))
            ->count(50)
            ->create();
    }
}
