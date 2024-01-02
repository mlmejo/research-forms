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

        <form action="" method="get">
            <div class="row mb-3">
                <div class="col-md-4">
                    <select class="custom-select" id="select-form" name="formId">
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
                    <select class="custom-select" id="select-department" name="departmentId">
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

            <div class="row align-items-center mb-3">
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
                        <option value="Summer class">Summer class</option>
                    </select>
                </div>

                <div class="col-md-4 pl-0">
                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive" id="table-content">
            @include('submissions.partial.table', [
                'students' => $students,
            ])
        </div>
    </div>
@endsection
