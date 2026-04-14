<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route hiển thị trang chi tiết
Route::get('laptop/detail/{id}', [HomeController::class, 'detail']);

// Route xử lý thêm vào giỏ hàng
Route::post('cart/add/{id}', [HomeController::class, 'addToCart']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';
