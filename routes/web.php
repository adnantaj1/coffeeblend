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
    Route::get('product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'singleProduct'])->name('product.single');
    // add to cart
    Route::post('product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'addCart'])->name('add.cart')->middleware("auth:web");

    Route::get('cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('cart')->middleware("auth:web");

    //delete product from cart
    Route::get('cart-delete/{id}', [App\Http\Controllers\Products\ProductsController::class, 'deleteProductCart'])->name('cart.product.delete');

    //checkout
    Route::post('prepare-checkout', [App\Http\Controllers\Products\ProductsController::class, 'prepareCheckout'])->name('prepare.checkout');
    Route::get('checkout', [App\Http\Controllers\Products\ProductsController::class, 'checkout'])->name('checkout')->middleware('check.for.price');
    Route::post('checkout', [App\Http\Controllers\Products\ProductsController::class, 'storeCheckout'])->name('process.checkout')->middleware('check.for.price');

    Route::get('success', [App\Http\Controllers\Products\ProductsController::class, 'success'])->name('products.pay.success')->middleware('check.for.price');

    // booking table
    Route::post('booking', [App\Http\Controllers\Products\ProductsController::class, 'bookTables'])->name('booking.tables');
    //Menu
    Route::get('menu', [App\Http\Controllers\Products\ProductsController::class, 'menu'])->name('products.menu');
});

Route::group(['prefix' => 'users'], function () {
    //User Pages
    Route::get('orders', [App\Http\Controllers\Users\UserController::class, 'displayOrders'])->name('users.orders')->middleware("auth:web");
    Route::get('bookings', [App\Http\Controllers\Users\UserController::class, 'displayBookings'])->name('users.bookings')->middleware("auth:web");

    // product review
    Route::get('write-review', [App\Http\Controllers\Users\UserController::class, 'writeReview'])->name('write.reviews');
    Route::post('write-review', [App\Http\Controllers\Users\UserController::class, 'processWriteReview'])->name('process.write.review');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [App\Http\Controllers\Admins\AdminController::class, 'viewLogin'])->name('view.login')->middleware('check.for.auth');
    Route::post('login', [App\Http\Controllers\Admins\AdminController::class, 'checkLogin'])->name('check.login');

    Route::get('index', [App\Http\Controllers\Admins\AdminController::class, 'index'])->name('admins.dashboard')->middleware("auth:admin");
    //admins
    Route::get('all-admins', [App\Http\Controllers\Admins\AdminController::class, 'displayAdmins'])->name('all.admins')->middleware("auth:admin");
    Route::get('create-admins', [App\Http\Controllers\Admins\AdminController::class, 'createAdmins'])->name('create.admins')->middleware("auth:admin");
    Route::post('create-admins', [App\Http\Controllers\Admins\AdminController::class, 'storeAdmins'])->name('store.admins')->middleware("auth:admin");

    //Orders
    Route::get('all-orders', [App\Http\Controllers\Admins\AdminController::class, 'displayOrders'])->name('all.orders')->middleware("auth:admin");
    Route::get('detail-order/{id}', [App\Http\Controllers\Admins\AdminController::class, 'orderDetails'])->name('order.details')->middleware("auth:admin");
    Route::put('update-status/{orderId}', [App\Http\Controllers\Admins\AdminController::class, 'updateStatus'])->name('update-status')->middleware("auth:admin");


    Route::delete('delete-order/{id}', [App\Http\Controllers\Admins\AdminController::class, 'deleteOrder'])->name('delete.order')->middleware("auth:admin");

    //PRODUCTS
    Route::get('all-products', [App\Http\Controllers\Admins\AdminController::class, 'displayProducts'])->name('all.products')->middleware("auth:admin");

    //BOOKINGS
    Route::get('all-bookings', [App\Http\Controllers\Admins\AdminController::class, 'displayBookings'])->name('all.bookings')->middleware("auth:admin");
    Route::get('detail-booking/{id}', [App\Http\Controllers\Admins\AdminController::class, 'bookingDetails'])->name('booking.details')->middleware("auth:admin");
    Route::delete('delete-booking/{id}', [App\Http\Controllers\Admins\AdminController::class, 'deleteBooking'])->name('delete.booking')->middleware("auth:admin");
    Route::put('update-status-booking/{bookingId}', [App\Http\Controllers\Admins\AdminController::class, 'updateBookingStatus'])->name('update-bookingStatus')->middleware("auth:admin");
});
