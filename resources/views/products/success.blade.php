@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Successful</div>
                <div class="card-body text-center">
                    <h3 class="text-success">Thank You for Your Purchase!</h3>
                    <p>Your payment has been processed successfully.</p>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Order Details</h4>
                        {{-- <p>Transaction ID: <strong>{{ session('transaction_id') }}</strong></p>
                        <p>Amount Paid: <strong>${{ session('amount_paid') }}</strong></p> --}}
                        <hr>
                        <p class="mb-0" style="color: black">Your order will be processed shortly. A confirmation email has been sent to <strong>{{ session('customer_email') }}</strong>.</p>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
