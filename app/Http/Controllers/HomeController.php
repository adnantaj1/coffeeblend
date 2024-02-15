<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Review;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::select()->orderBy('id', 'desc')->take('4')->get();
        $reviews = Review::select()->orderBy('id', 'desc')->take('5')->get();

        return view('home', compact('products', 'reviews'));
    }

    // function to handle more generic routed
    public function showPage($page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        // Optionally, handle non-existing pages
        abort(404);
    }
}
