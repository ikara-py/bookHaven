<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'book_id',
        'quantity',
        'price'
    ];

    public function cart(){
        return $this->BelongsTo(Cart::class);
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }

    
}
