@extends('layouts.app')

@section('content')
    <div class="p-3 bg-white">
        <div class="d-flex mb-4 align-items-center justify-content-between">
            <h2 class="h4 mb-0 font-weight-bold">Staff Management</h2>

            <a href="{{ route('staff.create') }}" class="btn btn-primary">
                New Staff
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
