@extends('layouts.admins')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Product</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('store.product') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Name input -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Product Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Price input -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="Product Price">
                            @error('price')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image input -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description input -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Type select -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="" selected>Choose Type</option>
                                <option value="Drinks" {{ old('type') == 'Drinks' ? 'selected' : '' }}>Drink</option>
                                <option value="Desserts" {{ old('type') == 'Desserts' ? 'selected' : '' }}>Dessert</option>
                            </select>
                            @error('type')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
