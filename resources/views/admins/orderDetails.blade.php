@extends('layouts.admins')
@section('content')

<div class="container mt-4">
    <div class="alert-container">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <h2 class="mb-4">Order Details</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <!-- Table contents -->
            <thead>
                <tr>
                    <th style="width: 30%;">Field</th>
                    <th style="width: 70%;">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Order ID</th>
                    <td>{{ $order->id }}</td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $order->status }}</td>
                </tr>
                <tr>
                    <th>Customer Name</th>
                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $order->address }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td>{{ $order->city }}</td>
                </tr>
                <tr>
                    <th>ZipCode</th>
                    <td>{{ $order->zip_code }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $order->state }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $order->email }}</td>
                </tr>
                <tr>
                    <th>Order Total</th>
                    <td>${{ $order->price }}</td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <h4>Update Order Status</h4>
            <form action="{{ route('update-status', $order->id) }}" method="POST" class="form-inline">
                @csrf
                @method('PUT')
                <div class="form-group mb-2">
                    <select name="status">
                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                        <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2 ml-2">Update Status</button>
            </form>
        </div>
        <div class="col-md-6 text-right">
            <h4>Delete Order</h4>
            <form action="{{route('delete.order', $order->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Order</button>
            </form>
        </div>
    </div>
</div>

<style>
    .alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        width: auto;
        z-index: 1050;
    }
</style>


@endsection
