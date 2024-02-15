@extends('layouts.admins')
@section('content')
<div class="container mt-4">
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
    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Admins</h5>
                        <a href="{{ route('create.admins') }}" class="btn btn-primary">Create Admins</a>
                    </div>
                    @if($allAdmins->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allAdmins as $admin)
                                        <tr>
                                            <th scope="row">{{ $admin->id }}</th>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No admins found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
