@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Alert!</strong> You can click Order Code to see order detail
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Customer Name</th>
                            <th>Order Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($orderList as $row)
                            <tr>
                                <td>{{ $row->created_at->format('j-F-Y') }}</td>
                                {{-- {{ route('order#detail') }} --}}
                                <td class="orderCode"><a
                                        href="{{ route('admin#orderDetail', $row->order_code) }}">{{ $row->order_code }}</a>
                                </td>
                                <td>{{ $row->customer_name }}</td>
                                <td>
                                    <select name="status" class="orderStatus" class="form-select">
                                        <option value="0" @if ($row->status == 0) selected @endif>Pending
                                        </option>
                                        @if ($row->order_count <= $row->stock)
                                            <option value="1" @if ($row->status == 1) selected @endif>Confirm
                                            </option>
                                        @endif
                                        <option value="2" @if ($row->status == 2) selected @endif>Reject
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    @if ($row->status == 0)
                                        <i class="fa-solid fa-spinner text-warning"></i>
                                    @elseif($row->status == 1)
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js-script')
    <script>
        $(document).ready(function() {
            // data = [];
            $('.orderStatus').change(function() {
                orderStatus = $(this).val();
                orderCode = $(this).parents("tr").find(".orderCode").text();
                data = {
                    'status': orderStatus,
                    'order_code': orderCode,
                };
                $.ajax({
                    type: 'get',
                    url: '/admin/order/statusChange',
                    data: data,
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.reload() : ''
                    }
                })
            })
        })
    </script>
@endsection
