@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Admin Profile ( <span class="text-danger">
                                {{ Auth::user()->role }}</span> )
                        </h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('profile#update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">

                            <img class="img-profile img-thumbnail" id="output"
                                src="{{ Auth::user()->profile == null ? asset('default/noImage.jpeg') : asset('profile/' . Auth::user()->profile) }}">

                            <input type="file" accept="image/*" name="image" id=""
                                class="form-control mt-1 @error('image')
                                is-invalid
                            @enderror"onchange="loadFile(event)">
                        </div>
                        <div class="col">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Name</label>
                                        <input type="text" name="name"
                                            class="form-control  @error('name')
                                    is-invalid
                                @enderror"
                                            value="{{ old('name', Auth::user()->name == null ? Auth::user()->nickname : Auth::user()->name) }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Email</label>
                                        <input type="text" name="email"
                                            class="form-control  @error('email')
                                    is-invalid
                                @enderror"
                                            value="{{ old('email', Auth::user()->email) }}" placeholder="Email...">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Phone</label>
                                        <input type="text" name="phone"
                                            class="form-control  @error('phone')
                                    is-invalid
                                @enderror"
                                            value="{{ old('email', Auth::user()->phone) }}" placeholder="09xxxxxx">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Address</label>
                                        <input type="text" name="address"
                                            class="form-control  @error('address')
                                    is-invalid
                                @enderror"
                                            value="{{ old('address', Auth::user()->address) }}" placeholder="Address">
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <input type="submit" value="Update" class="btn btn-primary mt-3">
                            <a href="{{ route('password#changePage') }}">Change Password</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
