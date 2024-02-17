@extends('layouts.admins')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-6 mb-5 ftco-animate">
            <!-- Current Product Image -->
            <div class="text-center">
                <img src="{{ asset('assets/images/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            </div>
        </div>
        <div class="col-lg-6 product-details pl-md-5 ftco-animate">
            <form action="{{ route('update.product', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-light p-5 contact-form">
                @csrf
                @method('PUT')
                <h3 class="mb-4">Edit Product</h3>
                <div class="form-group">
                    <label for="name" class="text-dark">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                </div>
                <div class="form-group">
                    <label for="price" class="text-dark">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                </div>
                <div class="form-group">
                    <label for="description" class="text-dark">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ $product->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="type" class="text-dark">Type</label>
                    <select class="form-control" id="type" name="type">
                        <option value="Drinks" {{ $product->type == 'Drinks' ? 'selected' : '' }}>Drink</option>
                        <option value="Desserts" {{ $product->type == 'Desserts' ? 'selected' : '' }}>Dessert</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image" class="text-dark">Product Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <!-- Display Current Image -->
                    <div class="mt-3">
                        <img src="{{ asset('assets/images/' . $product->image) }}" alt="Current Image" style="width: 100px; height: auto;">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary py-3 px-5">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
