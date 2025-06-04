@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <a href="{{ route('category#page') }}" class="btn primary">Back</a>
                    <div class="card-body shadow">
                        <form action="{{ route('category#update', $category->id) }}" method="post" class="p-3 rounded">
                            @csrf
                            <input type="text" name="categoryName" value="{{ $category->name, old('categoryName') }}"
                                class=" form-control @error('categoryName')
                                in-valid
                            @enderror">
                            @error('categoryName')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                            <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
