<table class="table table-sm table-striped" id="table">
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Department</th>
            <th>School Year</th>
            <th>Semester</th>
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
                <td>{{ $student->school_year }}</td>
                <td>{{ $student->semester }}</td>
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
