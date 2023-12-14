@extends('layouts.app')

@section('content')
    <div class="p-3 shadow-sm bg-white">
        <h2 class="h4 mb-2 font-weight-bold">Research Forms</h2>

        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Research Form</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($researchForms as $researchForm)
                        <tr>
                            <td>
                                <a
                                    href="{{ $researchForm->submitted ? route('research-forms.submissions.edit', $researchForm) : route('research-forms.submissions.create', $researchForm) }}">
                                    {{ $researchForm->title }}
                                </a>
                            </td>
                            <td>
                                @if ($researchForm->submitted)
                                    @php
                                        $student = \App\Models\Student::where('user_id', '=', Auth::id())->first();
                                        $submission = \App\Models\Submission::where(
                                            'research_form_id', '=', $researchForm->id,
                                        )->where('student_id', '=', $student->id)->first();
                                    @endphp

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
                                @else
                                    <span class="text-danger">Missing</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
