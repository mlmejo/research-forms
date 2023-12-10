@extends('layouts.app')

@section('content')
    <div class="p-3 bg-white">
        <h2 class="h4 mb-4 font-weight-bold">New Form</h2>

        <form action="{{ route('research-forms.store') }}" method="post">
            @csrf

            <div class="form-group col-md-6 p-0">
                <label for="title">Research Form Title</label>

                @error('title')
                    <input type="text" name="title" id="title" class="form-control is-invalid">
                @else
                    <input type="text" name="title" id="title" class="form-control">
                @enderror

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
