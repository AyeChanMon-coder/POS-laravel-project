@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <a href="{{ route('product#list') }}" class="btn btn-sm btn-secondary">List Page</a>
        <div class="row">
            <div class="col-8 offset-2 card p-3 shadow-sm rounded">
                <div class="card">
                    <div class="mb-3">
                        <div class="text-center">
                            <img class="img-profile rounded mt-2 mb-1 w-25" id="output"
                                src="{{ asset('productImages/' . $product->image) }}">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-title">
                            <div class="mb-3">
                                <h3 class="h3 text-center">{{ $product->name }}</h3>
                                <span class="text-black m-3 text-center">{{ $product->price }}MMK</span>
                            </div>
                        </div>
                        <div class="m-2">
                            <p class="p-1">
                                <span class="text-muted">{{ $product->category_name }}</span>
                            </p>
                            <p class="p-1">
                                <span class="text-muted">Stock: {{ $product->stock }}</span>
                            </p>
                            <p class="p-2">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
