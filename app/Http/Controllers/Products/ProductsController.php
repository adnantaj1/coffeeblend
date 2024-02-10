<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function singleProduct($id)
    {
        $product = Product::find($id);
        $retlatedProducts = Product::where('type', $product->type)
            ->where('id', '!=', $id)->take(4)->orderby('id', 'desc')->get();
        return view('products.productSingle', compact('product', 'retlatedProducts'));
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
        echo "Item added to cart";
        //return view('products.productSingle', compact('product', 'retlatedProducts'));
    }
}
