@extends('layouts.app')

@section('content')
    <div class="p-3 bg-white">
        <form action="{{ route('announcements.update', $announcement) }}" method="post">
            @csrf
            @method('PATCH')

            <h2 class="h4 mb-4 font-weight-bold">Create announcement</h2>

            <div class="form-group col-md-6 p-0">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" value="{{ $announcement->title }}" class="form-control">
            </div>

            <div class="form-group col-md-6 p-0">
                <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $announcement->content }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Update
            </button>
        </form>
    </div>
@endsection
