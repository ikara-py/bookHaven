<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'profile_image',
        'country',
        'date_of_birth',
        'date_of_death',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'date_of_death' => 'date',
        ];
    }

    public function books(){
        return $this->hasMany(Book::class);
    }
}
