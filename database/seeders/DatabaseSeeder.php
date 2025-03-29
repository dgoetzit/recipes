<?php

namespace Database\Seeders;

use Database\Seeders\RecipesSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(RecipesSeeder::class);
    }
}
