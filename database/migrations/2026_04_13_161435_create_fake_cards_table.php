<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fake_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_number')->unique();
            $table->string('expiry_date');
            $table->string('cvv');
            $table->decimal('balance', 10, 2)->default(1000.00);
            $table->string('cardholder_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fake_cards');
    }
};
