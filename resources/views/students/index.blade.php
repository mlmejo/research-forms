@extends('layouts.app')

@section('content')
    <div class="p-3 bg-white">
        <h2 class="h4 mb-4 font-weight-bold">Student Management</h2>

        <div class="table-responsive">
            <table class="table table-sm table-striped" id="table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Course</th>
                        <th>Control Number</th>
                        <th>Leader</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->user->full_name }}</td>
                            <td>{{ $student->department->name }}</td>
                            <td>{{ $student->course->name }}</td>
                            <td>{{ $student->control_number }}</td>
                            @if ($student->is_leader)
                                <td class="text-success">Yes</td>
                            @else
                                <td>Yes</td>
                            @endif
                            <td>
                                <a href="{{ route('students.edit', $student) }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
