@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2 card p-3 shadow-sm rounded">
                <form action="{{ route('product#update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="oldPhoto" value="{{ $product->image }}">
                    <input type="hidden" name="productId" value="{{ $product->id }}">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="text-center">
                                <img class="img-profile rounded mb-1 w-25" id="output"
                                    src="{{ asset('productImages/' . $product->image) }}">
                            </div>
                            <input type="file" accept='image/*' name="image" id=""
                                class="form-control mt-1 @error('image')is-invalid @enderror" onchange="loadFile(event)">
                            @error('image')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ $product->name, old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Name...">
                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select name="categoryId" id=""
                                        class="form-control @error('categoryId') is-invalid @enderror">
                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}"@if ($product->category_id == $category->id) selected = "selected" @endif>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoryId')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" name="price" value="{{ $product->price, old('price') }}"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="Enter Price"
                                        required min="100">
                                    @error('price')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="stock" value="{{ $product->stock, old('stock') }}"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Enter Stock..." required min="0">
                                    @error('stock')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="" cols="30" rows="10"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description...">{{ $product->description, old('description') }} </textarea>
                            @error('description')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Update Product" class=" btn btn-primary w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
@endsection
