@extends('layouts.app')

@section('content')
    <div class="p-3 bg-white">
        <h2 class="h4 mb-4 font-weight-bold">
            {{ $submission->title }}
        </h2>

        <iframe src="{{ $uri }}"
            width="600px"
            height="400px"
        ></iframe>

        <div class="mt-3">
            <a href="{{ $uri }}" class="btn btn-primary">
                Download Document
            </a>
        </div>
    </div>
@endsection
