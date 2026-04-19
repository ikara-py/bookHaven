<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\SellerProfile;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory()->count(10)->create();
        $authors = Author::factory()->count(15)->create();

        $sellers = User::factory()->count(3)->create(['role' => 'seller']);
        
        foreach ($sellers as $seller) {
            SellerProfile::create([
                'user_id' => $seller->id,
                'store_name' => $seller->full_name . "'s Collection",
                'is_approved' => true
            ]);
        }
        
        User::factory()->count(10)->create(['role' => 'buyer']);

        for ($i = 0; $i < 40; $i++) {
            Book::factory()->create([
                'seller_id' => $sellers->random()->id,
                'category_id' => $categories->random()->id,
                'author_id' => $authors->random()->id,
            ]);
        }

        $orwell = Author::firstOrCreate(['name' => 'George Orwell']);
        $classics = Category::firstOrCreate(['name' => 'Classics']);
        
        Book::factory()->create([
            'title' => 'Animal Farm',
            'author_id' => $orwell->id,
            'category_id' => $classics->id,
            'seller_id' => $sellers->random()->id,
            'type' => 'digital',
            'pdf_path' => 'ebooks/animal_farm.pdf',
            'description' => 'A satirical allegorical novella, in the form of a beast fable, by George Orwell, first published in England on 17 August 1945.',
            'price' => 9.99,
            'stock' => 999,
        ]);
    }
}
