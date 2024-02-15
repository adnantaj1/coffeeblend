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

use function PHPSTORM_META\type;

class ProductsController extends Controller
{
    public function singleProduct($id)
    {
        $product = Product::find($id);
        $retlatedProducts = Product::where('type', $product->type)
            ->where('id', '!=', $id)->take(4)->orderby('id', 'desc')->get();
        // Check if there is an authenticated user before checking the cart
        if (Auth::check()) {
            $checkingInCart = Cart::where('product_id', $id)
                ->where('user_id', Auth::user()->id)
                ->count();
        } else {
            // If no user is authenticated, set $checkingInCart to 0 or another suitable default value
            $checkingInCart = 0;
        }

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
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $cartProducts = Cart::where('user_id', $userId)->orderby('id', 'desc')->get();
            $totalPrice = Cart::where('user_id', $userId)->sum('price');
        } else {
            $cartProducts = collect([]);
            $totalPrice = 0;
            // Optionally, redirect to login page or show a message that the user needs to be logged in
            // return redirect()->route('login')->with('error', 'You need to be logged in to view the cart.');
        }

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
        // Define validation rules excluding 'user_id'
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'phone' => 'required|numeric',
            'message' => 'nullable|string',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Ensure user is authenticated before creating a booking
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to book a table.');
        }

        // Append 'user_id' to the validated data
        $bookingData = $validator->validated() + ['user_id' => Auth::id()];

        // Create booking
        $bookTables = Booking::create($bookingData);

        // Redirect with success message
        return redirect()->route('home')->with('booking', 'Table booked successfully!');
    }


    public function menu()
    {
        $menu = Product::select()->get();
        $desserts = Product::select()->where("type", "desserts")
            ->orderby('id', 'desc')->take(8)->get();
        $drinks = Product::select()->where("type", "drinks")
            ->orderby('id', 'desc')->take(8)->get();

        return view('products.menu', compact('desserts', 'drinks'));
    }
}
