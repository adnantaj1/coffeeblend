<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Product\Booking;
use App\Models\Product\Order;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function viewLogin()
    {
        return view('admins.login');
    }

    public function checkLogin(Request $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect()->route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }

    public function index()
    {
        $productsCount = Product::select()->count();
        $ordersCount = Order::select()->count();
        $bookingsCount = Booking::select()->count();
        $adminsCount = Admin::select()->count();

        return view('admins.index', compact('productsCount', 'ordersCount', 'bookingsCount', 'adminsCount'));
    }

    // ADMINS
    public function displayAdmins()
    {
        $allAdmins = Admin::select()->orderby('id', 'desc')->get();
        return  view('admins.allAdmins', compact('allAdmins'));
    }

    public function createAdmins()
    {
        return view('admins.createAdmins');
    }

    public function storeAdmins(Request $request)
    {
        // Define validation rules
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8',
        ]);

        // Proceed with admin creation using validated data
        $storeAdmins = Admin::create([
            "name" => $validatedData['name'],
            "email" => $validatedData['email'],
            "password" => Hash::make($validatedData['password']),
        ]);

        // Check if the admin was successfully created
        if ($storeAdmins) {
            return Redirect::route('all.admins')->with(['success' => "A new Admin is created."]);
        } else {
            return Redirect::route('all.admins')->with(['success' => "Something went wrong, unable to create Admin."]);
        }
    }

    //ORDERS
    public function displayOrders()
    {
        $allOrders = Order::select()->orderby('id', 'desc')->get();
        return  view('admins.allOrders', compact('allOrders'));
    }

    public function orderDetails($id)
    {
        $order = Order::find($id);
        //dd($order);
        if ($order) {
            return view('admins.orderDetails', compact('order'));
        }
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        $order->delete();
        //dd($order);
        if ($order) {
            return Redirect::route('all.orders')->with(['success' => "Order Deleted Successfully"]);
        }
    }
}
