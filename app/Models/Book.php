<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'sellar_id',
        'category_id',
        'author_id',
        'title',
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
}
