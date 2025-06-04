@extends('admin.layouts.master')
@section('content')
    <div class="container">

        <div class=" d-flex justify-content-between my-2">
            <div class="">
                <button class=" btn btn-secondary rounded shadow-sm"> <i class="fa-solid fa-database"></i>
                    Product Count ({{ count($products) }}) </button>
                <a href="{{ route('product#list') }}" class=" btn btn-outline-primary  rounded shadow-sm">All Products</a>
                <a href="{{ route('product#list', 'lowAmt') }}" class=" btn btn-outline-danger  rounded shadow-sm">Low Amount
                    Product
                    List</a>
            </div>
            <div class="">
                <form action="{{ route('product#list') }}" method="get">
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (count($products) != 0)
                            @foreach ($products as $item)
                                <tr>
                                    <td> <img src="{{ asset('/productImages/' . $item->image) }}"
                                            class=" img-thumbnail rounded shadow-sm" style="width:100px" alt="">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }} mmk</td>
                                    <td class="">
                                        <button type="button" class="btn btn-secondary position-relative">
                                            {{ $item->stock }}
                                            @if ($item->stock <= 3)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    Low amt stock
                                                </span>
                                            @endif
                                        </button>
                                    </td>
                                    <td>{{ $item->category_name }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <a href="{{ route('product#detail', $item->id) }}"
                                                    class="btn btn-sm btn-outline-primary"> <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a href="{{ route('product#editPage', $item->id) }}"
                                                    class="btn btn-sm btn-outline-secondary"> <i
                                                        class="fa-solid fa-pen-to-square"></i> </a>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteProcess({{ $item->id }})"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-muted text-center">There is no products</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js-script')
    <script>
        function deleteProcess($id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    setInterval(() => {
                        location.href = '/admin/product/delete/' + $id
                    }, 2000);
                }
            });
        }
    </script>
@endsection
