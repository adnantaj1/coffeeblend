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
    <h2 class="mb-4">Booking Details</h2>
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
                    <th>Booking ID</th>
                    <td>{{ $booking->id }}</td>
                </tr>
                <tr>
                    <th>Booking Date</th>
                    <td>{{ $booking->date }}</td>
                </tr>
                <tr>
                    <th>Booking Time</th>
                    <td>{{ $booking->time}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $booking->status }}</td>
                </tr>
                <tr>
                    <th>Customer Name</th>
                    <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td>{{ $booking->phone }}</td>
                </tr>
                <tr>
                    <th>Message</th>
                    <td>{{ $booking->message }}</td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <h4>Update Booking Status</h4>
            <form action="{{ route('update-bookingStatus', $booking->id) }}" method="POST" class="form-inline">
                @csrf
                @method('PUT')
                <div class="form-group mb-2">
                    <select name="status">
                        <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Processing" {{ $booking->status == 'Processing' ? 'selected' : '' }}>Booked</option>
                        <option value="Cancelled" {{ $booking->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2 ml-2">Update Status</button>
            </form>
        </div>
        <div class="col-md-6 text-right">
            <h4>Delete Booking</h4>
            <form action="{{route('delete.booking', $booking->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Booking</button>
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
