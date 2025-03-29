<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory {

    public function definition(): array
    {
        $name = fake()->text(80);
        $slug = Str::slug($name, '-');

        return [
            'name' => $name,
            'slug' => $slug,
            'email' => fake()->email(),
            'description' => $this->faker->text(1000),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
