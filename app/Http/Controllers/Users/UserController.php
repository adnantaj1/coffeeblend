<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Product\Booking;
use App\Models\Product\Order;
use App\Models\Product\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function displayOrders()
    {
        $orders = Order::select()->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('users.orders', compact('orders'));
    }

    public function displayBookings()
    {
        $bookings = Booking::select()->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('users.bookings', compact('bookings'));
    }

    public function writeReview()
    {
        return view('users.writereview');
    }

    public function processWriteReview(Request $request)
    {
        // Validate the review input
        $validatedData = $request->validate([
            'review' => 'required|string|min:5', // Ensure review is at least 5 characters long
        ]);

        try {
            // Create the review using the validated data and the authenticated user's name
            $writeReviews = Review::create([
                "name" => Auth::user()->name,
                "user_id" => Auth::id(), // Use user_id instead of name for better normalization
                "review" => $validatedData['review'],
            ]);

            // Check if the review was successfully created
            if ($writeReviews) {
                return redirect()->route('write.reviews')->with('reviews', 'Review submitted successfully');
            } else {
                // Return back with an error if the review was not saved
                return Redirect::back()->with('reviews', 'Failed to submit the review');
            }
        } catch (\Exception $e) {
            // Catch any exceptions and return back with an error message
            return Redirect::back()->with('reviews', 'An error occurred while submitting the review: ' . $e->getMessage())->withInput();
        }
    }
}
