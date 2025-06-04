@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{ route('user#list') }}"> <button class=" btn btn-sm btn-secondary">User List</button> </a>
            <div class="">
                <form action="{{ route('user#list') }}" method="get">
                    @csrf
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
                        @foreach ($userList as $user)
                            <tr>
                                <td>
                                    <img class="img-thumbnail w-75"
                                        src="{{ $user->profile == null ? asset('default/profilePic.jpg') : asset('profile/' . $user->profile) }}">
                                </td>
                                <td class="col-2">{{ $user->name != null ? $user->name : $user->nickname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->address == null)
                                        <i class="fa-solid fa-circle-xmark text-danger" style="opacity:0.8">
                                    @endif{{ $user->address }}</i>
                                </td>
                                <td>
                                    @if ($user->phone == null)
                                        <i class="fa-solid fa-circle-xmark text-danger" style="opacity:0.8">
                                    @endif{{ $user->phone }}
                                </td>
                                <td><span
                                        class="btn btn-sm bg-danger text-white rounded shadow-sm">{{ $user->role }}</span>
                                </td>
                                <td>{{ $user->created_at->format('j-F-Ys') }}</td>
                                <td>
                                    @if ($user->provider == 'simple')
                                        <i class="fa-solid fa-user"></i>
                                    @elseif($user->provider == 'google')
                                        <i class="fa-brands fa-google text-primary"></i>
                                    @elseif($user->provider == 'github')
                                        <i class="fa-brands fa-square-github text-dark"></i>
                                    @endif
                                </td>
                                <td>
                                    <button type='button' class="btn btn-sm btn-outline-danger"
                                        onclick="deleteProcess({{ $user->id }})"> <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <span class=" d-flex justify-content-end">{{ $userList->links() }}</span>

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
                        location.href = '/admin/account/userDelete/' + $id
                    }, 2000);
                }
            });
        }
    </script>
@endsection
