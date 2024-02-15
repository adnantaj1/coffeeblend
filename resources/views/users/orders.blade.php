@extends('layouts.app')
@section('content')
    <section class="ftco-section">
        <div class="container">
            <h2 class="text-center mb-4" style="color: white">Order History</h2>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Orders</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">City</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="text-center">
                                            <td>{{ $order->first_name }}</td>
                                            <td>{{ $order->last_name }}</td>
                                            <td>{{ $order->address }}</td>
                                            <td>{{ $order->city }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>${{ $order->price }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $order->status === 'Pending' ? 'badge-warning' : 'badge-success' }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            @if ($order->status == 'delivered')
                                                <td>
                                                    <a class="btn btn-success" href="{{ route('write.reviews') }}">Write
                                                        Review</a>
                                                </td>
                                            @else
                                                <td>
                                                    <button class="btn btn-secondary" disabled>Not Available</button>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
