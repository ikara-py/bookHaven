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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('author_id')->constrained();
            $table->string('title');
            $table->string('isbn')->unique()->nullable();
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->unsignedInteger('stock')->nullable(0);
            $table->year('publication_year')->nullable();
            $table->string('language')->default('en');
            $table->unsignedInteger('page_count')->nullable();
            $table->string('pdf_path')->nullable();
            $table->float('rating')->default(0);
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('downloads')->default(0);
            $table->enum('type', ['physical', 'digital'])->default('physical');
            $table->enum('status', ['active', 'inactive', 'sold', 'rejected'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
