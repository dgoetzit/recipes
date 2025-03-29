<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class RecipesSeeder extends Seeder
{
    public function run(): void
    {
        Recipe::factory()->hasAttached(
            Ingredient::factory()->count(rand(4, 10)),
            function() {
                return [
                    'measure_amount' => rand(1, 10),
                    'measure_unit' => fake()->randomElement(['oz', 'lbs', 'tsp', 'tbsp']),
                ];
            }
        )
        ->afterCreating(function (Recipe $recipe) {
            $stepsCount = rand(6, 10);

            Step::factory()
                ->count($stepsCount)
                ->sequence(fn ($sequence) => ['step_number' => $sequence->index + 1])
                ->for($recipe)
                ->create();
        })
            ->count(50)
            ->create();
    }
}
