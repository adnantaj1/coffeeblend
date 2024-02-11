<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
}
