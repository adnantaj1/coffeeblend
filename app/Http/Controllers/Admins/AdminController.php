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
use Illuminate\Support\Facades\File;


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

    public function productDetails($id)
    {
        $product = Product::find($id);
        //dd($order);
        if ($product) {
            return view('admins.productDetails', compact('product'));
        }
    }
    public function createProduct()
    {
        return view('admins.createProduct');
    }

    public function storeProduct(Request $request)
    {
        // Validate the request data first
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'description' => 'required|string|max:1000',
            'type' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $destinationPath = 'assets/images/'; // Define the destination path
            $myimage = $request->image->getClientOriginalName(); // Get original file name
            // Move the file to the destination path
            $request->image->move(public_path($destinationPath), $myimage);

            // Create the product with validated data
            $product = Product::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'description' => $validatedData['description'],
                'type' => $validatedData['type'],
                'image' => $myimage, // Save the path of the image
            ]);

            // Check if the product was successfully created
            if ($product) {
                return Redirect::route('all.products')->with('success', "A new product has been created.");
            }
        }

        // Handle failure
        return Redirect::back()->with('success', "Something went wrong, unable to create the product.")->withInput();
    }

    // Update Product
    public function updateProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string|max:1000',
            'type' => 'required|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 'sometimes' allows the field to be nullable
        ]);

        $product = Product::findOrFail($id);
        $currentImage = $product->image;

        // Handle file upload
        if ($request->hasFile('image')) {
            $destinationPath = 'assets/images/';
            $myimage = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path($destinationPath), $myimage);
            $validatedData['image'] = "$myimage";

            // Optionally delete old image
            if (File::exists(public_path($currentImage))) {
                File::delete(public_path($currentImage));
            }
        } else {
            $validatedData['image'] = $currentImage; // Keep the current image if new one is not uploaded
        }

        $product->update($validatedData);

        return Redirect::route('all.products')->with('success', 'Product witn updated successfully.');
    }

    //DELETE PRODUCT
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if (File::exists(public_path('assets/images/' . $product->image))) {
            File::delete(public_path('assets/images/' . $product->image));
        }
        $product->delete();
        //dd($order);
        if ($product) {
            return Redirect::route('all.products')->with(['success' => "Product Deleted Successfully"]);
        }
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

    public function showPage($page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        // Optionally, handle non-existing pages
        abort(404);
    }
}
