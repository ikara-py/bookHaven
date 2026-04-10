<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FakeCard extends Model
{
    protected $fillable = [
        'card_number',
        'expiry_date',
        'cvv',
        'balance',
        'cardholder_name',
    ];
}
