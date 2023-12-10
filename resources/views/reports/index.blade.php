@extends('layouts.app')

@section('content')
    <div class="p-3 bg-white">
        <div class="d-flex align-items-center justify-content-end">
            <button id="print" type="button" class="btn btn-sm btn-primary">
                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                    <path
                        d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                </svg>
                Print
            </button>
        </div>

        <div id="report">
            <h2 class="h4 mb-0 font-weight-bold">Research Form Submission Report</h2>
            <p class="text-muted mb-3">{{ now()->format('F d, Y h:i A') }}</p>

            <div class="table-responsive mt-3">
                <table class="table table-sm table-striped">
                    <tbody>
                        <tr>
                            <th>Submission per department: </th>
                            <th>Pending</th>
                            <th>Rejected</th>
                            <th>Approved</th>
                        </tr>
                        @foreach ($departments as $department)
                            @php
                                $submissions = \App\Models\Submission::join('students', 'submissions.student_id', '=', 'students.id')
                                    ->where('students.department_id', '=', $department->id)
                                    ->get();
                            @endphp
                            <tr>
                                <td>{{ $department->name }}</td>
                                <td>{{ $submissions->where('status', '=', 'pending')->count() }}</td>
                                <td>{{ $submissions->where('status', '=', 'rejected')->count() }}</td>
                                <td>{{ $submissions->where('status', '=', 'approved')->count() }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>Submission per course:</th>
                            <th>Pending</th>
                            <th>Rejected</th>
                            <th>Approved</th>
                        </tr>
                        @foreach ($courses as $course)
                            @php
                                $submissions = \App\Models\Submission::join('students', 'submissions.student_id', '=', 'students.id')
                                    ->where('students.course_id', '=', $course->id)
                                    ->get();
                            @endphp
                            <tr>
                                <td>{{ $course->name }}</td>
                                <td>{{ $submissions->where('status', '=', 'pending')->count() }}</td>
                                <td>{{ $submissions->where('status', '=', 'rejected')->count() }}</td>
                                <td>{{ $submissions->where('status', '=', 'approved')->count() }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>Submission per group:</th>
                            <th>Pending</th>
                            <th>Rejected</th>
                            <th>Approved</th>
                        </tr>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->control_number }}</td>
                                <td>{{ $student->submissions->where('status', '=', 'pending')->count() }}</td>
                                <td>{{ $student->submissions->where('status', '=', 'rejected')->count() }}</td>
                                <td>{{ $student->submissions->where('status', '=', 'approved')->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $("#print").on("click", function() {
            $("#report").printThis({
                importCSS: true,
                importStyle: true,
                loadCSS: ["{{ asset('css/app.min.css') }}"],
            });
        });
    </script>
@endpush
