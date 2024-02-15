@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if (Session::has('reviews'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('reviews') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ftco-animate">
                <form method="POST" action="{{ route('process.write.review') }}" class="billing-form ftco-bg-dark p-5 rounded">
                    <h3 class="mb-4 billing-heading text-center" style="color: white">Review</h3>
                    @csrf
                    <div class="form-group">
                        <textarea name="review" cols="30" rows="5" class="form-control" placeholder="Write your review here..."></textarea>
                        @error('review')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" name="submit" class="btn btn-primary py-2 px-5">Submit Review</button>
                    </div>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
