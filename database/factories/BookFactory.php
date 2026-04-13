<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'seller_id' => 1,
            'category_id' => 1,
            'author_id' => 1,
            'title' => ucwords($this->faker->words(rand(2, 5), true)),
            'isbn' => $this->faker->unique()->isbn13(),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 5, 45),
            'original_price' => $this->faker->boolean(40) ? $this->faker->randomFloat(2, 46, 90) : null,
            'stock' => $this->faker->numberBetween(0, 50),
            'publication_year' => $this->faker->year(),
            'language' => $this->faker->randomElement(['en', 'en', 'fr', 'es']),
            'page_count' => $this->faker->numberBetween(150, 600),
            'type' => $type = $this->faker->randomElement(['physical', 'digital']),
            'pdf_path' => $type === 'digital' ? 'ebooks/animal_farm.pdf' : null,
            'status' => 'active',
        ];
    }
}
