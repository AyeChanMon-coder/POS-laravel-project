@extends('user.layouts.master')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                    </div>
                    <a href="{{ route('user#orderList') }}" class=" text-black m-3"> <i
                            class="fa-solid fa-arrow-left-long"></i> Back</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>Order Code</td>
                        <td>{{ $orderProducts[0]->order_code }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            @if ($orderProducts[0]->status == 0)
                                <span class="text-warning">Pending</span>
                            @elseif($orderProducts[0]->status == 1)
                                <span class="text-success">Confirm</span>
                            @else
                                <span class="text-danger">Reject</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ordered Date</td>
                        <td>{{ $orderProducts[0]->created_at->format('j-F-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Total Amount<span class="text-sm">(+ deli fee)</span></td>
                        <td>{{ $orderProducts[0]->total_amt }} MMK</td>
                    </tr>
                </table>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm " id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2">Image</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Product Price (each)</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($orderProducts as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('productImages/' . $item->image) }}" class="w-50">
                                    </td>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>{{ $item->count }}</td>
                                    <td>{{ $item->price }} MMK</td>
                                    <td>{{ $item->price * $item->count }} MMK</td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
