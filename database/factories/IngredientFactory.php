<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement($this->ingredients()),
        ];
    }

    private function ingredients(): array
    {
        return [
            'salt',
            'pepper',
            'olive oil',
            'butter',
            'garlic',
            'onion',
            'flour',
            'sugar',
            'eggs',
            'milk',
            'chicken',
            'beef',
            'tomato',
            'potato',
            'carrot',
            'celery',
            'rice',
            'pasta',
            'cheese',
            'lemon',
            'honey',
            'vinegar',
            'soy sauce',
            'cilantro',
            'basil',
            'thyme',
            'oregano',
            'cumin',
            'cinnamon',
            'vanilla',
            'chocolate',
            'mushroom',
            'bell pepper',
            'spinach',
            'avocado',
            'beans',
            'chickpeas',
            'yogurt',
            'cream',
            'broth',
            'wine',
            'mustard',
            'mayonnaise',
            'ginger',
            'turmeric',
            'nuts',
            'coconut milk',
            'lime',
            'corn',
            'baking powder',
        ];
    }
}
