<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Buyer\{AuthorController, BookController, CartController, CategoryController, OrderController, WishlistController};
use App\Http\Controllers\Seller\{SellerBookController, SellerOrderController};
use App\Http\Controllers\Admin\{AdminBookController, AdminUserController, AdminOrderController};
use App\Http\Controllers\ProfileController;

Route::get('/', fn() => redirect()->route('books.index'))->name('home');
 

Route::get('/register',[AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::get('/login',[AuthController::class, 'showLogin'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
 

Route::get('/books',[BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}',[BookController::class, 'show'])->name('books.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
 

Route::middleware('auth')->group(function () {
 
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('role:buyer,seller')->group(function () {
        Route::get('/cart',[CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/items',[CartController::class, 'addItem'])->name('cart.add');
        Route::delete('/cart/items/{itemId}',[CartController::class, 'removeItem'])->name('cart.remove');
        Route::delete('/cart',[CartController::class, 'clear'])->name('cart.clear');
 
        Route::get('/orders',[OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders',[OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}',[OrderController::class, 'show'])->name('orders.show');
 
        Route::get('/wishlist',[WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/toggle',[WishlistController::class, 'toggle'])->name('wishlist.toggle');
    });
 

    Route::middleware('role:seller')->prefix('seller')->name('seller.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Seller\SellerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('books', SellerBookController::class)->middleware('seller_approved');
        Route::get('orders',[SellerOrderController::class, 'index'])->name('orders.index');
        Route::patch('orders/{item}/status',[SellerOrderController::class, 'updateStatus'])->name('orders.status');
    });


    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard',[AdminUserController::class, 'dashboard'])->name('dashboard');
 
        Route::get('users',[AdminUserController::class, 'index'])->name('users.index');
        Route::patch('users/{id}/status',[AdminUserController::class, 'updateStatus'])->name('users.updateStatus');
        Route::patch('users/{id}/role',[AdminUserController::class, 'updateRole'])->name('users.updateRole');
        Route::patch('users/{id}/approve',[AdminUserController::class, 'approveSeller'])->name('users.approveSeller');
 
        Route::resource('books',AdminBookController::class)->only(['index','update','destroy']);
        Route::get('orders',[AdminOrderController::class, 'index'])->name('orders.index');
        Route::patch('orders/{order}/status',[AdminOrderController::class, 'updateStatus'])->name('orders.status');
    });
});
