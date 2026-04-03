<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'category_id',
        'author_id',
        'title',
        'isbn',
        'cover',
        'description',
        'price',
        'original_price',
        'stock',
        'publication_year',
        'language',
        'page_count',
        'pdf_path',
        'type',
        'status',
    ];

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function getCoverUrlAttribute()
    {
        if (!$this->cover) {
            return $this->getRandomFallbackCover();
        }

        if (filter_var($this->cover, FILTER_VALIDATE_URL)) {
            return $this->cover;
        }

        if (Storage::disk('public')->exists($this->cover)) {
            return asset('storage/' . $this->cover);
        }

        return $this->getRandomFallbackCover();
    }

    private function getRandomFallbackCover()
    {
        $directory = public_path('images/covers');
        $files = glob($directory . '/cover (*).png');
        $count = count($files);

        if ($count > 0) {
            $imageNumber = (($this->id ?? 1) % $count) + 1;
            return asset("images/covers/cover ({$imageNumber}).png");
        }

        return asset('images/default-book-cover.png');
    }
}
