@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3 card p-3 shadow-sm rounded">

                <div class=" d-flex justify-content-end">
                    <a href="{{ route('admin#list') }}" class=" btn bg-danger my-2 w-25 rounded shadow-sm text-white"> <i
                            class="fa-solid fa-users"></i> Admin List</a>
                </div>

                <div class="card-title bg-dark text-white p-3 h5">New Admin Account</div>

                <form action="{{ route('newAdmin#create') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name')
                                is-invalid
                            @enderror"
                                placeholder="Enter Name...">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}"
                                class="form-control @error('email')
                                is-invalid
                            @enderror"
                                placeholder="Enter Email...">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" value=""
                                class="form-control @error('password')
                                is-invalid
                            @enderror "
                                placeholder="Enter Password...">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirmPassword" value=""
                                class="form-control @error('confirmPassword')
                                is-invalid
                            @enderror "
                                placeholder="Enter Confirm Passoword...">
                            @error('confirmPassword')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Create Account" class=" btn btn-primary w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection
