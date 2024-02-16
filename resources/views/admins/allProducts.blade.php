@extends('layouts.admins')
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
<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                 <div class="mb-4 text-right">
                    <a href="{{ route('create.product') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Create Product
                    </a>
                </div>
                <div class="cart-list">
                    <table class="table">
                        <thead>
                            <tr class="text-center" style="background-color: #007bff; color: white;">
                                <th scope="col">ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Product</th>
                                <th scope="col">Type</th>
                                <th scope="col">Price</th>
                                <th scope="col">Update</th>
                                <th scope="col">Remove</th>
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
                                    <td class="align-middle">{{ $product->type }}</td>
                                    <td class="align-middle">${{ $product->price }}</td>
                                    <td><a href="{{ route('product.details', ['id' => $product->id]) }}" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i> Update</a></td>
                                    <td>

                                        <form action="{{ route('delete.product', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                 Delete
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
@endsection
