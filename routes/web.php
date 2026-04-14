<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route hiển thị trang chi tiết
Route::get('laptop/detail/{id}', [HomeController::class, 'detail']);

// Route xử lý thêm vào giỏ hàng
Route::post('cart/add/{id}', [HomeController::class, 'addToCart']);

// Route hiển thị giỏ hàng
Route::get('cart', [HomeController::class, 'viewCart'])->name('cart.view');
Route::get('gio-hang', [HomeController::class, 'viewCart'])->name('cart.index');

// Route xóa sản phẩm khỏi giỏ hàng
Route::post('cart/remove/{id}', [HomeController::class, 'removeFromCart'])->name('cart.remove');

// Route xử lý đặt hàng
Route::post('cart/checkout', [HomeController::class, 'checkout'])->name('cart.checkout');

// Route xem trang xác nhận đặt hàng thành công
Route::get('cart/order-success', [HomeController::class, 'orderSuccess'])->name('cart.success')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
