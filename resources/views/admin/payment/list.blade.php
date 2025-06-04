@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="text-center mb-4">
            <h1 class="h3 mb-0 text-primary text-uppercase">Payment Management</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body shadow">
                            <h1 class="h5 mb-0 text-gray-800 text-center">New Payment</h1>
                            <form action="{{ route('payment#create') }}" method="post" class="p-3 rounded">
                                @csrf
                                <div class="my-2">
                                    <input type="number" name="accountNumber" value="{{ old('accountNumber') }}"
                                        class=" form-control @error('accountNumber')
                                    is-invalid @enderror"
                                        placeholder="Account Number...">
                                    @error('accountNumber')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="my-2">
                                    <input type="text" name="accountName" value="{{ old('accountName') }}"
                                        class=" form-control @error('accountName')
                                    is-invalid @enderror"
                                        placeholder="Account Name...">
                                    @error('accountName')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="my-2">
                                    <input type="text" name="accountType" value="{{ old('accountType') }}"
                                        class=" form-control @error('accountType')
                                    is-invalid @enderror"
                                        placeholder="Account Type...">
                                    @error('accountType')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="offset-6 col-6 mb-2">
                        <form action="{{ route('payment#list') }}" method="get">
                            <div class="input-group">
                                <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                    class=" form-control" placeholder="Enter Search Key...">
                                <button type="submit" class=" btn bg-dark text-white"> <i
                                        class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <table class="table table-hover shadow-sm ">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Account Number</th>
                                <th>Account Name</th>
                                <th>Account Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountInfo as $account)
                                <tr>
                                    <td>{{ $account->account_number }}</td>
                                    <td>{{ $account->account_name }}</td>
                                    <td>{{ $account->type }}</td>
                                    <td>
                                        <a href="{{ route('payment#edit', $account->id) }}"
                                            class="btn btn-sm btn-outline-secondary"> <i
                                                class="fa-solid fa-pen-to-square"></i> </a>
                                        <button type='button' class="btn btn-sm btn-outline-danger"
                                            onclick="deleteProcess({{ $account->id }})"> <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <span class=" d-flex justify-content-end">{{ $accountInfo->links() }}</span>

                </div>
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
                        location.href = '/admin/payment/paymentDelete/' + $id
                    }, 2000);
                }
            });
        }
    </script>
@endsection
