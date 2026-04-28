<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\SellerProfile;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService{
    public function register($data){
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'buyer',
            'gender' => $data['gender'],
            'phone' => $data['phone'] ?? null,
            'city' => $data['city'] ?? null,
            'country' => $data['country'] ?? null,
            'address' => $data['address'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'bio' => $data['bio'] ?? null,
        ]);

        Cart::create(['user_id' => $user->id]);
        Wishlist::create(['user_id' => $user->id]);

        if($user->isSeller() && !empty($data['store_name'])){
            SellerProfile::create([
                'user_id' => $user->id,
                'store_name' => $data['store_name'],
            ]);
        }
        return $user;
    }

    public function login($credentials, $remember = false){
        $user = User::where('email', $credentials['email'])->first();

        if($user && $user->status === 'suspended'){
            throw new \Exception('Your account has been suspended');
        }

        return Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']],
            $remember
        );
    }

    public function logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }



}