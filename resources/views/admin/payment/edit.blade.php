@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="offset-3 col-4">
                <div class="text-center mb-4">
                    <h1 class="h3 mb-0 text-primary text-uppercase">Edit Payment Information</h1>
                </div>
                <div class="card">
                    <div class="card-body shadow">
                        <a href="{{ route('payment#list') }}" class="btn btn-primary">Back</a>
                        <form action="{{ route('payment#update') }}" method="post" class="p-3 rounded">
                            @csrf
                            <input type="hidden" name="accountId" value="{{ $account->id }}">
                            <div class="my-2">
                                <input type="number" name="accountNumber"
                                    value="{{ $account->account_number, old('accountNumber') }}"
                                    class=" form-control @error('accountNumber')
                                is-invalid @enderror">
                                @error('accountNumber')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="my-2">
                                <input type="text" name="accountName"
                                    value="{{ $account->account_name, old('accountName') }}"
                                    class=" form-control @error('accountName')
                                is-invalid @enderror">
                                @error('accountName')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="my-2">
                                <input type="text" name="accountType" value="{{ $account->type, old('accountType') }}"
                                    class=" form-control @error('accountType')
                                is-invalid @enderror">
                                @error('accountType')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <input type="submit" value="Update" class="w-100 btn btn-outline-info mt-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
