@extends('user.layouts.master')
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
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (count($orderList) != 0)
                            @foreach ($orderList as $row)
                                <tr>
                                    <td>{{ $row->created_at->format('j-F-Y') }}</td>
                                    {{-- --}}
                                    <td><a href="{{ route('order#detail', $row->order_code) }} ">{{ $row->order_code }}</a>
                                    </td>
                                    <td>
                                        @if ($row->status == 0)
                                            <i class="fa-solid fa-spinner text-warning"></i>
                                        @elseif ($row->status == 1)
                                            <i class="fa-solid fa-check text-success"></i>
                                        @else
                                            <i class="fa-solid fa-xmark text-danger"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-muted text-center">There is no Order</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
