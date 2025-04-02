<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory
{
    protected static array $sharedEmails = [];

    public function definition(): array
    {
        $name = $this->generateRandomRecipeName();
        $slug = Str::slug($name, '-');

        if (empty(self::$sharedEmails)) {
            for ($i = 0; $i < 10; $i++) {
                self::$sharedEmails[] = fake()->unique()->safeEmail();
            }
        }

        return [
            'name' => $name,
            'slug' => $slug,
            'email' => $this->getEmail(),
            'description' => fake()->text(1000),
            'image' => '/image-' . fake()->numberBetween(1, 10) . '.avif',
            'image_alt' => fake()->text(10),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'views' => fake()->numberBetween(0, 9999),
            'rating' => fake()->numberBetween(3, 5),
            'reviews' => fake()->numberBetween(20, 100),
        ];
    }

    protected function getEmail(): string
    {
        if (fake()->boolean(50) && ! empty(self::$sharedEmails)) {
            return fake()->randomElement(self::$sharedEmails);
        }

        return fake()->unique()->safeEmail();
    }

    protected function generateRandomRecipeName(): string
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
