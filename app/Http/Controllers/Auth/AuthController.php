<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService){}

    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(RegisterRequest $request){
        $this->authService->register($request->validated());
        return redirect()->route('login')->with('success', 'Account created');
    }

    public function login(LoginRequest $request){
        try {
            $loggedIn = $this->authService->login(
                $request->only('email', 'password'),
                $request->boolean('remember')
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        if(!$loggedIn){
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }
        $request->session()->regenerate();

        $user = $request->user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }

        return redirect()->intended(route('books.index'));
    }

    public function logout(){
        $this->authService->logout();
        return redirect()->route('login');
    }
}
