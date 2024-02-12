@extends('layouts.app')

@section('content')
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <form method="POST" action="{{ route('process.checkout') }}" class="billing-form ftco-bg-dark p-3 p-md-5">
                    <h3 class="mb-4 billing-heading">Billing Details</h3>
                    @csrf
                    <div class="row align-items-end">
                        {{-- First Name --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- Last Name --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- State/Country --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="country">State / Country</label>
                                <div class="select-wrap">
                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                    <select name="state" id="country" class="form-control">
                                        <option value="Denmark">Denmark</option>
                                        <option value="France">France</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Finland">Findland</option>
                                        {{-- Other options --}}
                                    </select>
                                </div>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- Address --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="streetaddress">Street Address</label>
                                <input type="text" name="address" class="form-control" placeholder="House number and street name">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- City --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="towncity">Town / City</label>
                                <input type="text" name="city" class="form-control" placeholder="City">
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- Zip Code --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postcodezip">Postcode / ZIP *</label>
                                <input type="text" name="zip_code" class="form-control" placeholder="Zipcode">
                                @error('zip_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- Phone --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- Email Address --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailaddress">Email Address</label>
                                <input type="text" name="email" class="form-control" placeholder="">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- Hidden Inputs for Price and User ID (No need for validation error display) --}}
                        <div class="col-md-6">
                            <input type="hidden" value="{{ Session::get('price') }}" name="price">
                            <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                        </div>
                        {{-- Submit Button --}}
                        <div class="col-md-12">
                            <div class="form-group mt-4">
                                <button type="submit" name="submit" class="btn btn-primary py-3 px-4">Place an order</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection
