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
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($researchForms as $researchForm)
                        @php
                            $student = \App\Models\Student::where('user_id', '=', Auth::id())->first();
                            $submission = \App\Models\Submission::where('research_form_id', '=', $researchForm->id)
                                ->where('student_id', '=', $student->id)
                                ->first();
                        @endphp
                        <tr>
                            <td>
                                @if ($researchForm->submitted && $submission->status != 'rejected')
                                    <a
                                        href="{{ route('research-forms.submissions.show', [$studentId, $researchForm]) }}">
                                        {{ $researchForm->title }}
                                    </a>
                                @elseif ($researchForm->submitted && $submission->status == 'rejected')
                                    <a
                                        href="{{ route('research-forms.submissions.edit', $researchForm) }}">
                                        {{ $researchForm->title }}
                                    </a>
                                @else
                                    <a href="{{ route('research-forms.submissions.create', $researchForm) }}">
                                        {{ $researchForm->title }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($researchForm->submitted)
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
                            <td>
                                @if ($researchForm->submitted)
                                    {{ $submission->remark }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
