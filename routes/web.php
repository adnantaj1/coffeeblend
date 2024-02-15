<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
// for more generic routes
Route::get('/{page}', [App\Http\Controllers\HomeController::class, 'showPage'])->where('page', '^(services|about|contact)$')->name('page.show');



Route::group(['prefix' => 'products'], function () {
    // Single product
    Route::get('/product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'singleProduct'])->name('product.single');
    // add to cart
    Route::post('/product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'addCart'])->name('add.cart')->middleware("auth:web");

    Route::get('/cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('cart')->middleware("auth:web");

    //delete product from cart
    Route::get('/cart-delete/{id}', [App\Http\Controllers\Products\ProductsController::class, 'deleteProductCart'])->name('cart.product.delete');

    //checkout
    Route::post('/prepare-checkout', [App\Http\Controllers\Products\ProductsController::class, 'prepareCheckout'])->name('prepare.checkout');
    Route::get('/checkout', [App\Http\Controllers\Products\ProductsController::class, 'checkout'])->name('checkout')->middleware('check.for.price');
    Route::post('/checkout', [App\Http\Controllers\Products\ProductsController::class, 'storeCheckout'])->name('process.checkout')->middleware('check.for.price');

    Route::get('/success', [App\Http\Controllers\Products\ProductsController::class, 'success'])->name('products.pay.success')->middleware('check.for.price');

    // booking table
    Route::post('/booking', [App\Http\Controllers\Products\ProductsController::class, 'bookTables'])->name('booking.tables');
    //Menu
    Route::get('/menu', [App\Http\Controllers\Products\ProductsController::class, 'menu'])->name('products.menu');
});

Route::group(['prefix' => 'users'], function () {
    //User Pages
    Route::get('/orders', [App\Http\Controllers\Users\UserController::class, 'displayOrders'])->name('users.orders')->middleware("auth:web");
    Route::get('/bookings', [App\Http\Controllers\Users\UserController::class, 'displayBookings'])->name('users.bookings')->middleware("auth:web");

    // product review
    Route::get('/write-review', [App\Http\Controllers\Users\UserController::class, 'writeReview'])->name('write.reviews');
    Route::post('/write-review', [App\Http\Controllers\Users\UserController::class, 'processWriteReview'])->name('process.write.review');
});
