@extends('layouts.app')
@section('content')

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
@if ($cartProducts->isEmpty())
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-info text-center p-4" role="alert" style="font-size: 1.25rem;">
                <p class="text-black">Your cart is <strong>currently empty</strong>.</p>
                <p><a href="{{ route('home') }}" class="alert-link" style="font-weight: bold; font-size: 1.5rem; color: #007bff; text-decoration: underline;">Start adding some products now!</a></p>
            </div>
        </div>
    </div>
</div>

@else
<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead>
                            <tr class="text-center" style="background-color: #007bff; color: white;">
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartProducts as $index => $cartProduct)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $index + 1 }}</td>
                                    <td class="image-prod align-middle">
                                        <img src="{{ asset('assets/images/' . $cartProduct->image) }}" alt="Product"
                                            class="img-fluid" style="width: 75px; height: auto;">
                                    </td>
                                    <td class="product-name align-middle">
                                        <h5>{{ $cartProduct->name }}</h5>
                                        <p>{{ $cartProduct->description }}</p>
                                    </td>
                                    <td class="align-middle">${{ $cartProduct->price }}</td>
                                    <td class="align-middle">
                                        <input type="number" name="quantity" class="form-control text-center"
                                            value="1" min="1" max="100">
                                    </td>
                                    <td class="align-middle">${{$cartProduct->price}}</td>
                                    <td class="align-middle">
                                        <a href="{{ route('cart.product.delete', ['id' => $cartProduct->product_id]) }}"
                                            class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Cart totals and checkout button -->
        <div class="row justify-content-end">
            <div class="col col-lg-3 col-md-6 mt-5 cart-wrap ftco-animate">
                <div class="cart-total mb-3">
                    <h3 style="color: white" >Cart Totals</h3>
                    <p class="d-flex">
                        <span>Subtotal</span>
                        <span>${{$totalPrice}}</span>
                    </p>
                    <p class="d-flex">
                        <span>Delivery</span>
                        <span>$0.00</span>
                    </p>
                    <hr>
                    <p class="d-flex total-price">
                        <span>Total</span>
                        <span>${{$totalPrice}}</span>
                    </p>
                </div>
                <form  method="POST" action="{{route('prepare.checkout')}}">
                    @csrf
                    <input name="price" type="hidden" value="{{$totalPrice}}">
                    <button   class="btn btn-primary py-3 px-4">Proceed to Checkout</button>
                </form>
            </div>
    </div>
</section>
@endif
@endsection
