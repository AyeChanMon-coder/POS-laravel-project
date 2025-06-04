@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Sale Information</h6>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-dark">Total Amount</button>
                    <button type="button" class="btn btn-info">{{ $saleTotalPrice }} MMK</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm " id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Order Code</th>
                                <th>Customer Name</th>
                                <th>Shipping Address</th>
                                <th>Contact No</th>
                                <th>Order Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saleInfo as $row)
                                <tr>
                                    <td>{{ $row->order_code }}</td>
                                    <td>{{ $row->user_name }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->created_at->format('j-F-Y') }}</td>
                                    <td>{{ $row->total_amt }} MMK</td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
