<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->generateRandomRecipeName();
        $slug = Str::slug($name, '-');

        return [
            'name' => $name,
            'slug' => $slug,
            'email' => fake()->email(),
            'description' => fake()->text(1000),
            'image' => fake()->randomElement($this->images()),
            'image_alt' => fake()->text(10),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'views' => fake()->numberBetween(0, 9999),
            'rating' => fake()->numberBetween(3, 5),
            'reviews' => fake()->numberBetween(20, 100),
        ];
    }

    private function images(): array
    {
        return [
            'https://images.unsplash.com/photo-1482049016688-2d3e1b311543?q=80&w=3220&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8Zm9vZHxlbnwwfHwwfHx8Mg%3D%3D',
            'https://images.unsplash.com/photo-1484723091739-30a097e8f929?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTN8fGZvb2R8ZW58MHx8MHx8fDI%3D',
            'https://images.unsplash.com/photo-1473093295043-cdd812d0e601?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fGZvb2R8ZW58MHx8MHx8fDI%3D',
            'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?q=80&w=3270&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ];
    }

    private function generateRandomRecipeName(): string
    {
        $cookingMethods = [
            'Baked', 'Grilled', 'Roasted', 'Sautéed', 'Fried',
            'Steamed', 'Braised', 'Seared', 'Smoked', 'Stir-Fried',
            'Slow-Cooked', 'Pan-Seared', 'Poached', 'Broiled', 'Glazed',
        ];

        $ingredients = [
            'Chicken', 'Beef', 'Pork', 'Salmon', 'Shrimp',
            'Potato', 'Carrot', 'Mushroom', 'Spinach', 'Tomato',
            'Garlic', 'Lemon', 'Orange', 'Apple', 'Mango',
            'Chocolate', 'Cinnamon', 'Basil', 'Avocado', 'Coconut',
        ];

        $dishTypes = [
            'Stew', 'Soup', 'Salad', 'Pasta', 'Rice',
            'Curry', 'Casserole', 'Pie', 'Bowl', 'Sandwich',
            'Tacos', 'Risotto', 'Skillet', 'Stir-Fry', 'Delight',
            'Surprise', 'Special', 'Medley', 'Fusion', 'Bake',
        ];

        $adjectives = [
            'Creamy', 'Spicy', 'Sweet', 'Tangy', 'Savory',
            'Zesty', 'Hearty', 'Fresh', 'Crispy', 'Rustic',
            'Homestyle', 'Classic', 'Gourmet', 'Signature', 'Aromatic',
        ];

        $namePatterns = [
            fn () => fake()->randomElement($adjectives) . ' ' .
                    fake()->randomElement($ingredients) . ' ' .
                    fake()->randomElement($dishTypes),

            fn () => fake()->randomElement($cookingMethods) . ' ' .
                    fake()->randomElement($ingredients) . ' ' .
                    fake()->randomElement($dishTypes),

            fn () => fake()->randomElement($adjectives) . ' ' .
                    fake()->randomElement($cookingMethods) . ' ' .
                    fake()->randomElement($ingredients),

            fn () => fake()->randomElement($ingredients) . ' ' .
                    fake()->randomElement($ingredients) . ' ' .
                    fake()->randomElement($dishTypes),

            fn () => fake()->randomElement($ingredients) . ' and ' .
                    fake()->randomElement($ingredients) . ' ' .
                    fake()->randomElement($dishTypes),
        ];

        $patternFunction = fake()->randomElement($namePatterns);

        return $patternFunction();
    }
}
