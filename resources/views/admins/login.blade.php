@extends('layouts.admins')

@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title text-center mb-4" style="font-size: 24px;">Login</h5>
                <form method="POST" action="{{ route('check.login') }}">
                    <!-- Email input -->
                    @csrf
                    <div class="mb-3">
                        <input type="email" name="email" id="form2Example1" class="form-control form-control-lg" placeholder="Email Address" required>
                    </div>

                    <!-- Password input -->
                    <div class="mb-3">
                        <input type="password" name="password" id="form2Example2" class="form-control form-control-lg" placeholder="Password" required>
                    </div>

                    <!-- Submit button -->
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
