@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{ route('admin#list') }}"> <button class=" btn btn-sm btn-secondary  ">Admin List</button> </a>
            <div class="">
                <form action="{{ route('admin#list') }}" method="get">
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
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            <th>Platform</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adminList as $admin)
                            <tr>

                                <td>
                                    <img class="img-thumbnail w-75"
                                        src="{{ $admin->profile == null ? asset('default/profilePic.jpg') : asset('profile/' . $admin->profile) }}">

                                </td>
                                <td class="col-2">{{ $admin->name != null ? $admin->name : $admin->nickname }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @if ($admin->address == null)
                                        <i class="fa-solid fa-circle-xmark text-danger" style="opacity:0.8">
                                    @endif{{ $admin->address }}</i>
                                </td>
                                <td>
                                    @if ($admin->phone == null)
                                        <i class="fa-solid fa-circle-xmark text-danger" style="opacity:0.8">
                                    @endif{{ $admin->phone }}
                                </td>
                                <td><span
                                        class="btn btn-sm bg-danger text-white rounded shadow-sm">{{ $admin->role }}</span>
                                </td>
                                <td>{{ $admin->created_at->format('j-F-Ys') }}</td>
                                <td>
                                    <i class="fa-solid fa-user"></i>
                                </td>
                                <td>
                                    @if ($admin->role != 'superadmin')
                                        <button type='button' class="btn btn-sm btn-outline-danger"
                                            onclick="deleteProcess({{ $admin->id }})"> <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <span class=" d-flex justify-content-end">{{ $adminList->links() }}</span>

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
                        location.href = '/admin/account/adminDelete/' + $id
                    }, 2000);
                }
            });
        }
    </script>
@endsection
