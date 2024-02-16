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
    //update status
    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $request->status;
            $order->save();

            return back()->with('success', 'Order status updated successfully.');
        }

        return back()->with('success', 'Order not found.');
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

    //PRODUCTS
    public function displayProducts()
    {
        $allProducts = Product::select()->orderby('id', 'desc')->get();
        return  view('admins.allProducts', compact('allProducts'));
    }

    //BOOKINGS
    public function displayBookings()
    {
        $allBookings = Booking::select()->orderby('id', 'desc')->get();
        return  view('admins.allBookings', compact('allBookings'));
    }

    public function bookingDetails($id)
    {
        $booking = Booking::find($id);
        //dd($order);
        if ($booking) {
            return view('admins.bookingDetails', compact('booking'));
        }
    }

    public function deleteBooking($id)
    {
        $booking = Booking::find($id);
        $booking->delete();
        //dd($order);
        if ($booking) {
            return Redirect::route('all.bookings')->with(['success' => "Booking Deleted Successfully"]);
        }
    }

    //update status
    public function updateBookingStatus(Request $request, $bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->status = $request->status;
            $booking->save();

            return back()->with('success', 'Booking status updated successfully.');
        }

        return back()->with('success', 'Booking not found.');
    }
}
