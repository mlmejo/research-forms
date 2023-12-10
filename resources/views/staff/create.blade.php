@extends('layouts.app')

@section('content')
    <div class="p-3 bg-white">
        <h2 class="h4 mb-4 font-weight-bold">New Admin</h2>

        <form action="{{ route('staff.store') }}" method="post">
            @csrf

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" autofocus required />
                </div>

                <div class="col-md-3 mt-3 mt-md-0">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required />
                </div>
            </div>

            <div class="form-group col-md-6 p-0">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" />
            </div>

            <div class="form-group col-md-6 p-0">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>

            <div class="form-group col-md-6 p-0">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
            </div>

            <button type="submit" class="btn btn-sm btn-primary">
                Submit
            </button>
        </form>
    </div>
@endsection
