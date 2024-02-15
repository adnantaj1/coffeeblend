@extends('layouts.app')
@section('content')

<section class="ftco-section">
    <div class="container">
        <h2 class="text-center mb-4" style="color: white">Bookings</h2>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">Booking ID</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                <tr class="text-center">
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->first_name }}</td>
                                    <td>{{ $booking->last_name }}</td>
                                    <td>{{ $booking->date }}</td>
                                    <td>{{ $booking->time }}</td>
                                    <td>{{ $booking->phone }}</td>
                                    <td>
                                        <span class="badge {{ $booking->status === 'Pending' ? 'badge-warning' : 'badge-success' }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    @if ($booking->status == "booked")
                                    <td>
                                        <a class="btn btn-success" href="{{route('write.reviews')}}"> Write Review</a>
                                    </td>
                                    @else
                                    <td>
                                        <a class="btn btn-secondary" href="#"> Not Available</a>
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
