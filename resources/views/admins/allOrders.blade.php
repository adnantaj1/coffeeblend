@extends('layouts.admins')
@section('content')
<div class="container mt-4">
    <div class="container mt-4">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show custom-alert-success" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Orders</h5>
                        <a href="#" class="btn btn-primary">Create Admins</a>
                    </div>
                    @if($allOrders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">City</th>
                                        <th scope="col">Zip Code</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allOrders as $order)
                                        <tr>
                                            <th scope="row">{{$order->id}}</th>
                                            <td>{{$order->first_name}} {{$order->last_name}}</td>
                                            <td>{{$order->phone}}</td>
                                            <td>{{$order->city}}</td>
                                            <td>{{$order->zip_code}}</td>
                                            <td>{{$order->price}}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $order->status === 'Processing' ? 'badge-warning' : 'badge-success' }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td><a href="{{ route('order.details', ['id' => $order->id]) }}" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i> Details</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No Orders found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
