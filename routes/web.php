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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Single product
Route::get('products/product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'singleProduct'])->name('product.single');
// add to cart
Route::post('products/product-single/{id}', [App\Http\Controllers\Products\ProductsController::class, 'addCart'])->name('add.cart');

Route::get('products/cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('cart');

//delete product from cart
Route::get('products/cart-delete/{id}', [App\Http\Controllers\Products\ProductsController::class, 'deleteProductCart'])->name('cart.product.delete');
