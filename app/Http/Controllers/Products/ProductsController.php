<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product\Booking;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Cart;
use App\Models\Product\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function singleProduct($id)
    {
        $product = Product::find($id);
        $retlatedProducts = Product::where('type', $product->type)
            ->where('id', '!=', $id)->take(4)->orderby('id', 'desc')->get();
        //checking for product in cart
        $checkingInCart = Cart::where('product_id', $id)
            ->where('user_id', Auth::user()->id)->count();
        return view('products.productSingle', compact('product', 'retlatedProducts', 'checkingInCart'));
    }

    public function addCart(Request $request, $id)
    {
        // First, check if product_id is present in the request
        if (!$request->has('product_id') || is_null($request->product_id)) {
            // Handle the error appropriately, maybe return an error response
            return response()->json(['error' => 'Product ID is required'], 400);
        }
        $addCart = Cart::create(
            [
                "product_id" => $request->product_id,
                "name" => $request->name,
                "image" => $request->image,
                "price" => $request->price,
                "user_id" => Auth::user()->id
            ]
        );
        return Redirect::route('product.single', $id)->with(['success' => "Your Product is Added to Cart"]);
    }

    public function cart()
    {
        $cartProducts = Cart::where('user_id', Auth::user()->id)
            ->orderby('id', 'desc')->get();

        $totalPrice = Cart::where('user_id', Auth::user()->id)->sum('price');

        return view('products.cart', compact('cartProducts', 'totalPrice'));
    }

    public function deleteProductCart($id)
    {
        $deleteProductCart = Cart::where('product_id', $id)
            ->where('user_id', Auth::user()->id)
            ->delete(); // Call delete directly on the query builder

        if ($deleteProductCart) {
            return Redirect::route('cart')
                ->with(['success' => "Product removed from Cart successfully"]);
        } else {
            return Redirect::route('cart')
                ->with(['error' => "Failed to remove the product from the cart"]);
        }
    }

    public function prepareCheckout(Request $request)
    {
        $value = $request->price;
        $price = Session::put('price', $value);

        $newPrice = Session::get($price);

        if ($newPrice > 0) {
            return Redirect::route('checkout');
        }
    }

    public function checkout()
    {
        return view('products.checkout');
    }

    public function storeCheckout(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // Add more validation rules as needed
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|numeric',
            'price' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Proceed with order creation if validation passes
        $checkout = Order::create($validator->validated());
        return view('products.pay');
        //return Redirect::route('payment.process', ['orderId' => $checkout->id])->with('success', 'Order placed successfully, proceed to payment.');


    }

    public function success()
    {
        $deleteCart = Cart::where('user_id', Auth::user()->id);
        $deleteCart->delete();
        if ($deleteCart) {
            Session::forget('price');
            return view('products.success');
        }
    }

    public function bookTables(Request $request)
    {

        if ($request->date > date('n/j/y')) {
            $bookTables = Booking::create($request->all());
            if ($bookTables)
                return Redirect::route('home')->with(['booking' => "Your Table is Booked "]);
        } else {
            return Redirect::route('home')->with(['date' => "Select a date in future. "]);
        }
    }
}
