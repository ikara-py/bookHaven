<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone',
        'profile_image',
        'role',
        'gender',
        'status',
        'date_of_birth',
        'city',
        'country',
        'address',
        'bio',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_verified' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(){
        return $this->role === 'admin';
    }
    public function isBuyer(){
        return in_array($this->role, ['buyer', 'buyer_seller']);
    }

    public function isSeller(){
        return in_array($this->role, ['seller','buyer_seller']);
    }

    public function sellerProfile(){
        return $this->hasOne(SellerProfile::class);
    }

    public function books(){
        return $this->hasMany(Book::class);
    }

    public function cart(){
        return $this->hasOne(Cart::class);
    }

    public function orders(){
        return $this->HasMany(Order::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
