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
                            <h5 class="card-title mb-0">Bookings</h5>
                        </div>
                        @if ($allBookings->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allBookings as $booking)
                                            <tr>
                                                <th scope="row">{{ $booking->id }}</th>
                                                <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                                                <td>{{ $booking->date }}</td>
                                                <td>{{ $booking->time }}</td>
                                                <td>{{ $booking->phone }}</td>
                                                <td>
                                                    <span
                                                        class="{{ $booking->status === 'Processing'
                                                            ? 'badge badge-warning'
                                                            : ($booking->status === 'Booked'
                                                                ? 'badge badge-success'
                                                                : ($booking->status === 'Cancelled'
                                                                    ? 'badge badge-danger'
                                                                    : '')) }}">
                                                        {{ $booking->status }}
                                                    </span>

                                                </td>

                                                <td><a href="{{ route('booking.details', ['id' => $booking->id]) }}"
                                                        class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i>
                                                        Details</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No Booking is found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
