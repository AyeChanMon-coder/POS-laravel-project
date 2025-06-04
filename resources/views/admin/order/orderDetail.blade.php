@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin#orderList') }}" class=" text-black m-3"> <i class="fa-solid fa-arrow-left-long"></i> Back</a>

        <!-- DataTales Example -->


        <div class="row">
            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Name :</div>
                        <div class="col-7">{{ $paymentHistory->user_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Shipping address :</div>
                        <div class="col-7">{{ $paymentHistory->address }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Code :</div>
                        <div class="col-7" id="orderCode">{{ $paymentHistory->order_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Date :</div>
                        <div class="col-7">{{ $paymentHistory->created_at }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Total Price :</div>
                        <div class="col-7">{{ $paymentHistory->total_amt }}
                            mmk<br>
                            <small class=" text-danger ms-1">( Contain Delivery Charges )</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Contact Phone :</div>
                        <div class="col-7">{{ $paymentHistory->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Payment Method :</div>
                        <div class="col-7">{{ $paymentHistory->payment_method }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Purchase Date :</div>
                        <div class="col-7">{{ $paymentHistory->created_at }}</div>
                    </div>
                    <div class="row mb-3">
                        <img style="width: 150px" src="{{ asset('PaymentImages/' . $paymentHistory->payslip_image) }}"
                            class=" img-thumbnail">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Order Board</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm " id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2">Image</th>
                                <th>Name</th>
                                <th>Order Count</th>
                                <th>Available Stock</th>
                                <th>Product Price (each)</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($orderProducts as $item)
                                <tr>
                                    <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                    <input type="hidden" class="productOrderCount" value="{{ $item->order_count }}">

                                    <td>
                                        <img src="{{ asset('productImages/' . $item->image) }}"
                                            class=" w-50 img-thumbnail">
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->order_count }}@if ($item->order_count > $item->stock)
                                            <span class="badge text-bg-danger">out-of-stock</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->stock }}</td>
                                    <td>{{ $item->price }}mmk</td>
                                    <td>{{ $item->order_count * $item->price }} mmk</td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <div class="">
                    @if ($status)
                        <input type="button" id="btn-order-confirm" class="btn btn-success rounded shadow-sm"
                            value="Confirm">
                    @endif
                    <input type="button" id="btn-order-reject" class="btn btn-danger rounded shadow-sm" value="Reject">
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js-script')
    <script>
        $('#btn-order-reject').click(function() {
            orderCode = $('#orderCode').text();
            status = 2;

            $.ajax({
                type: 'get',
                url: '/admin/order/statusChange',
                data: {
                    'order_code': orderCode,
                    'status': status,

                },
                dataType: 'json',
                success: function(res) {
                    res.status == 'success' ? location.href = '/admin/order/list' : location.reload()
                }
            })
        })
        $('#btn-order-confirm').click(function() {
            orderCode = $('#orderCode').text();
            orderList = [];
            $('#productTable tbody tr').each(function(index, row) {
                productId = $(row).find('.productId').val();
                count = $(row).find('.productOrderCount').val();
                orderList.push({
                    'productId': productId,
                    'count': count,
                    'orderCode': orderCode,
                })
            })
            $.ajax({
                type: 'get',
                url: '/admin/order/statusConfirm',
                data: Object.assign({}, orderList),
                dataType: 'json',
                success: function(res) {
                    res.status == 'success' ? location.href = '/admin/order/list' : location.reload()
                }
            })
        })
    </script>
@endsection
