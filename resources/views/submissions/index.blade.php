@extends('layouts.app')

@section('content')
    <div class="p-3 shadow-sm bg-white">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h4 mb-0 font-weight-bold">Research Forms</h2>
                <p class="text-muted mb-0">Form Title: {{ $researchForm->title }}</p>
            </div>

            @if (Auth::user()->hasRole('admin'))
                <a href="{{ route('research-forms.create') }}" class="btn btn-sm btn-primary">
                    Add Form
                </a>
            @endif
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <select class="custom-select" id="select-form">
                    <option value="">Select form</option>
                    @foreach ($researchForms as $researchForm)
                        @if (request()->query('formId') == $researchForm->id)
                            <option value="{{ $researchForm->id }}" selected>
                                {{ $researchForm->title }}
                            </option>
                        @else
                            <option value="{{ $researchForm->id }}">
                                {{ $researchForm->title }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 pl-0">
                <select class="custom-select" id="select-department">
                    <option value="">Select department</option>
                    @foreach ($departments as $department)
                        @if (request()->query('departmentId') == $department->id)
                            <option value="{{ $department->id }}" selected>
                                {{ $department->name }}
                            </option>
                        @else
                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <form action="" method="get" class="row align-items-center mb-3">
            <div class="col-md-4">
                <select name="school_year" class="custom-select" id="select-sy">
                    @foreach ($schoolYears as $schoolYear)
                        <option value="{{ $schoolYear }}">
                            {{ $schoolYear }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 pl-0">
                <select name="semester" class="custom-select" id="select-semester">
                    <option value="1st semester">
                        1st semester
                    </option>
                    <option value="2nd semester">2nd semester</option>
                </select>
            </div>

            <div class="col-md-4 pl-0">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-sm table-striped" id="table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Adviser</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>
                                <a
                                    href="{{ route('research-forms.submissions.show', [
                                        'student' => $student,
                                        'research_form' => request()->query('formId', 1),
                                    ]) }}">
                                    {{ $student->user->full_name }}
                                </a>
                            </td>
                            <td>{{ $student->department->name }}</td>
                            <td>
                                {{ $student->adviser }}
                            </td>
                            <td>
                                @php
                                    $submission = DB::table('submissions')
                                        ->where('student_id', '=', $student->id)
                                        ->where('research_form_id', '=', request()->query('formId', 1))
                                        ->first();
                                @endphp

                                @if (isset($submission))
                                    <span>{{ $submission->created_at }}</span>
                                @else
                                    N/A
                                @endif
                            </td>
                            @if (!isset($submission))
                                <td class="text-danger">Missing</td>
                            @else
                                <td>
                                    @switch ($submission->status)
                                        @case ('pending')
                                            <span class="text-warning">Pending</span>
                                        @break

                                        @case ('approved')
                                            <span class="text-success">Approved</span>
                                        @break

                                        @case ('rejected')
                                            <span class="text-danger">Rejected</span>
                                        @break
                                    @endswitch
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
