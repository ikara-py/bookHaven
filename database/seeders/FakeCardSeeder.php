<?php

namespace Database\Seeders;

use App\Models\FakeCard;
use Illuminate\Database\Seeder;

class FakeCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FakeCard::updateOrCreate(
            ['card_number' => '4242 4242 4242 4242'],
            [
                'expiry_date' => '12/28',
                'cvv' => '123',
                'balance' => 1500.00,
                'cardholder_name' => 'Demo User',
            ]
        );

        FakeCard::updateOrCreate(
            ['card_number' => '1234 5678 1234 5678'],
            [
                'expiry_date' => '01/25',
                'cvv' => '999',
                'balance' => 50.00,
                'cardholder_name' => 'Low Balance User',
            ]
        );
    }
}
