<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'store_description',
        'store_log',
        'rating',
        'is_approved',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
