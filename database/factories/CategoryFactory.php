<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            'Science Fiction', 'Fantasy', 'Mystery & Thriller', 
            'Romance', 'Historical Fiction', 'Non-Fiction', 
            'Biography', 'Business', 'Self-Help', 'Programming',
            'Cooking', 'Graphic Novels'
        ];
        
        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'description' => $this->faker->paragraph(),
        ];
    }
}
