<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        
        $buyers = User::whereIn('role', ['buyer', 'buyer_seller'])->get();
        $books = Book::all();
        
        if ($buyers->count() === 0 || $books->count() === 0) {
            $this->command->warn('Not enough buyers or books to seed orders.');
            return;
        }

        $this->command->info('Creating 10 random orders...');

        for ($i = 0; $i < 10; $i++) {
            $buyer = $buyers->random();
            $numItems = rand(1, 4);
            $selectedBooks = $books->random($numItems);
            
            $totalAmount = 0;
            foreach ($selectedBooks as $book) {
                $totalAmount += $book->price;
            }

            $order = Order::create([
                'user_id' => $buyer->id,
                'total_amount' => $totalAmount,
                'status' => $faker->randomElement(['pending', 'paid', 'completed']),
                'shipping_address' => $faker->address,
                'discount_amount' => 0,
            ]);

            foreach ($selectedBooks as $book) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'seller_id' => $book->seller_id,
                    'quantity' => 1,
                    'price' => $book->price,
                    'status' => $faker->randomElement(['pending', 'shipped', 'delivered']),
                ]);
            }

            if ($order->status !== 'pending') {
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $totalAmount,
                    'payment_method' => $faker->randomElement(['credit_card', 'paypal', 'stripe']),
                    'status' => 'completed',
                    'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                ]);
            }
        }
        
        $this->command->info('10 orders seeded successfully!');
    }
}
