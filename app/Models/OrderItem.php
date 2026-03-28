<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    Protected $fillable = [
        'order_id',
        'book_id',
        'seller_id',
        'quantity',
        'price',
        'status'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    }

}
