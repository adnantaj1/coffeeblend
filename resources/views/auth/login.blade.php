@extends('layouts.app')

@section('content')
<section style="background-image: url('{{asset('assets/images/bg_1.jpg')}}'); background-size: cover; background-position: center center; height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div style="background: rgba(0, 0, 0, 0.6); padding: 40px; border-radius: 8px; width: auto; max-width: 600px;">
        <div class="text-center" style="color: #fff; margin-bottom: 20px;">
            <h1>Login</h1>
            <p><a href="index.html" style="color: #f8f9fa; text-decoration: underline;">Home</a> / Login</p>
        </div>
        <form method="POST" action="{{ route('login') }}" style="color: #fff;">
            @csrf
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 5px; background-color: #c89c64; border: none;">Login</button>
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}" style="color: #ddd; text-decoration: underline;">Forgot Your Password?</a>
                @endif
            </div>
        </form>
    </div>
</section>

@endsection
