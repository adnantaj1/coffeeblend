@extends('layouts.admins')
@section('content')
<div class="container mt-4">
    <h2>Order Details</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
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

    <!-- Dropdown for updating status -->
    <div class="mb-3">
        <label for="statusDropdown" class="form-label">Update Status</label>
        <select class="form-select" id="statusDropdown" onchange="updateOrderStatus({{ $order->id }}, this.value)">
            <option selected>Select Status</option>
            <option value="Pending">Pending</option>
            <option value="Processing">Processing</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select>
    </div>

    <!-- Delete button -->
    {{-- {{ route('order.delete', $order->id) }} --}}
    <form action="{{route('delete.order', $order->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Order</button>
    </form>
</div>

<script>
function updateOrderStatus(orderId, status) {
    // AJAX call to update the status
    fetch(`/path-to-update-status/${orderId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if(data.success) {
            // Handle success
            alert('Order status updated successfully');
            location.reload(); // Reload the page to reflect changes
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

@endsection
