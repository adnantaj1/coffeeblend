@extends('layouts.admins')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">Products</div>
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text">{{ $productsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">Orders</div>
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text">{{ $ordersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                <div class="card-header">Bookings</div>
                <div class="card-body">
                    <h5 class="card-title">Total Bookings</h5>
                    <p class="card-text">{{ $bookingsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                <div class="card-header">Admins</div>
                <div class="card-body">
                    <h5 class="card-title">Total Admins</h5>
                    <p class="card-text">{{ $adminsCount }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
