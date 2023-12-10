@extends('layouts.app')

@section('content')
    <div class="p-3 bg-white">
        <h2 class="h4 mb-4 font-weight-bold">Update Admin Information</h2>

        <form action="{{ route('staff.update', $user) }}" method="post">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control"
                        value="{{ $user->first_name }}" autofocus required />
                </div>

                <div class="col">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{ $user->last_name }}" required />
                </div>
            </div>

            <div class="from-group col-md-6 p-0">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ $user->username }}" class="form-control">
            </div>

            <button type="submit" class="btn mt-3 btn-primary">
                Save
            </button>
        </form>
    </div>

    <div class="mt-3 p-3 bg-white">
        <h2 class="h4 mb-4 font-weight-bold">Reset Password</h2>

        <form action="{{ route('reset-password') }}" method="post">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}" />

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
            </div>

            <button type="submit" class="btn btn-primary">Confirm</button>
        </form>
    </div>
@endsection
