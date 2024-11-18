<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;



Route::get('/', function () {
    return Inertia::render('Welcome',);
})->name('welcome');
Route::get('about', function () {
    return Inertia::render('About');
})->name('about');


Route::get('products', [ProductController::class, 'index'])->name('products');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin/dashboard');
    Route::get('admin/products',  [ProductController::class, 'show'])->name('admin/products');
    Route::get('admin/orders',  [OrderController::class, 'show'])->name('admin/orders');
    Route::post('/admin/products', [ProductController::class, 'store']);
    Route::put('/admin/products/{product}', [ProductController::class, 'update']);
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy']);
    Route::post('admin/orders/changeStatus/{order}', [OrderController::class, 'adminchangeStatus'])->name('orders.changeStatus');

});

Route::middleware(['auth', 'role:user'])->group(function () {

Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('orders', [OrderController::class, 'view'])->name('orders');
Route::post('/orders/changeStatus/{order}', [OrderController::class, 'changeStatus'])->name('orders.changeStatus');

});


Route::get('/test', [OrderController::class, 'adminView']);



