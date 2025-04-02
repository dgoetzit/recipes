<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Database\Seeder;

class RecipesSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = Ingredient::factory()
            ->count(50)
            ->create();

        Recipe::factory()
            ->count(100)
            ->create()
            ->each(function (Recipe $recipe) use ($ingredients) {
                $recipeIngredients = $ingredients->random(rand(4, 10));

                $recipe->ingredients()->attach(
                    $recipeIngredients->mapWithKeys(function ($ingredient) {
                        return [
                            $ingredient->id => [
                                'measure_amount' => rand(1, 10),
                                'measure_unit' => fake()->randomElement(['oz', 'lbs', 'tsp', 'tbsp']),
                            ],
                        ];
                    })
                );

                $stepsCount = rand(6, 10);

                Step::factory()
                    ->count($stepsCount)
                    ->sequence(fn ($sequence) => ['step_number' => $sequence->index + 1])
                    ->for($recipe)
                    ->create();
            });
    }
}
