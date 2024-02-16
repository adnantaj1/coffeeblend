@extends('layouts.admins')
@section('content')

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead>
                            <tr class="text-center" style="background-color: #007bff; color: white;">
                                <th scope="col">ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Details</th>
                                {{-- <th scope="col">Remove</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allProducts as $product)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $product->id}}</td>
                                    <td class="image-prod align-middle">
                                        <img src="{{ asset('assets/images/' . $product->image) }}" alt="Product"
                                            class="img-fluid" style="width: 75px; height: 75px;">
                                    </td>
                                    <td class="product-name align-middle">
                                        <h5>{{ $product->name }}</h5>
                                    </td>
                                    <td class="align-middle">${{ $product->price }}</td>
                                    {{-- {{ route('order.details', ['id' => $order->id]) }} --}}
                                    <td><a href="#" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i> Details</a></td>
                                    {{-- <td class="align-middle">
                                        <a href="{{ route('cart.product.delete', ['id' => $product->product_id]) }}"
                                            class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
@endsection
