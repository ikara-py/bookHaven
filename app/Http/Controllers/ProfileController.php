<?php

namespace App\Http\Controllers;

use JonPurvis\Squeaky\Rules\Clean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user()->load('sellerProfile');
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'full_name' => ['required', 'string', 'max:255', new Clean()],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500', new Clean()],
            'bio' => ['nullable', 'string', 'max:1000', new Clean()],
            'gender' => ['required', 'in:male,female'],
            'date_of_birth' => ['required', 'date', 'before:today'],
        ];

        if ($request->filled('password') && $request->filled('password_confirmation')) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        if ($user->isSeller() && $user->sellerProfile) {
            $rules['store_name'] = ['required', 'string', 'max:255', new Clean()];
            $rules['store_description'] = ['nullable', 'string', 'max:1000', new Clean()];
        }

        $validated = $request->validate($rules);

        $user->update([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'city' => $validated['city'] ?? $user->city,
            'country' => $validated['country'] ?? $user->country,
            'address' => $validated['address'] ?? $user->address,
            'bio' => $validated['bio'] ?? $user->bio,
        ]);

        if ($request->filled('password') && $request->filled('password_confirmation')) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        if ($user->isSeller() && $user->sellerProfile) {
            $user->sellerProfile->update([
                'store_name' => $validated['store_name'],
                'store_description' => $validated['store_description'] ?? $user->sellerProfile->store_description,
            ]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }
}
