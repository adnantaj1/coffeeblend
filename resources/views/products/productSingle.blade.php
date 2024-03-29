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
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 ftco-animate">
                    <a href="{{ asset('assets/images/' . $product->image . '') }}" class="image-popup"><img
                            src="{{ asset('assets/images/' . $product->image . '') }}" class="img-fluid"
                            alt="Colorlib Template"></a>
                </div>
                <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                    <h3 class="text-white">{{ $product->name }}</h3>
                    <p class="price"><span>${{ $product->price }}</span></p>
                    <p>
                        {{ $product->description }}
                    </p>
                    <form method="POST" action="{{ route('add.cart', $product->id) }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <input type="hidden" name="image" value="{{ $product->image }}">
                        @if ($checkingInCart == 0)
                        <button type="submit" name="submit" class="btn btn-primary py-3 px-5" >Add to Cart</button>
                        @else
                        <button style="background-color: black" class="btn btn-primary py-3 px-5" disabled >Added to Cart</button>
                        @endif
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate text-center">
                    <span class="subheading">Discover</span>
                    <h2 class="mb-4 text-white">Related products</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                        the blind texts.</p>
                </div>
            </div>
            <div class="row">
                @foreach ($retlatedProducts as $relatedProduct)
                    <div class="col-md-3">
                        <div class="menu-entry">
                            <a href="{{ route('product.single', $relatedProduct->id) }}" class="img"
                                style="background-image: url({{ asset('assets/images/' . $relatedProduct->image . '') }});"></a>
                            <div class="text text-center pt-4">
                                <h3><a
                                        href="{{ route('product.single', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                                </h3>
                                <p>{{ $relatedProduct->description }}</p>
                                <p class="price"><span>${{ $relatedProduct->price }}</span></p>
                                <p><a href="{{ route('product.single', $relatedProduct->id) }}"
                                        class="btn btn-primary btn-outline-primary">Show</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
