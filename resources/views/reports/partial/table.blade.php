<div id="report">
    <h2 class="h4 mb-0 font-weight-bold">Research Form Submission Report</h2>
    <p class="text-muted mb-3">{{ now()->format('F d, Y h:i A') }}</p>

    <div class="table-responsive mt-3">
        <table class="table table-sm">
            <tbody>
                <tr style="background-color: rgba(0, 0, 0, 0.05);">
                    <th>Leader name:</th>
                    <th>Control number</th>
                    <th>School Year</th>
                    <th>Semester</th>
                    <th>Department</th>
                    <th>Year Level</th>
                    <th class="text-center">Total Submissions</th>
                </tr>
                @foreach ($students as $student)
                    <tr>
                        <td>
                            <a href="{{ route('research-forms.index', $student) }}" class="text-decoration-none">
                                {{ $student->user->first_name }} {{ $student->user->last_name }}
                            </a>
                        </td>
                        <td>{{ $student->control_number }}</td>
                        <td>{{ $student->school_year }}</td>
                        <td>{{ $student->semester }}</td>
                        <td>{{ $student->department->name }}</td>
                        <td>{{ $student->year_level }}</td>
                        <td class="text-center">
                            {{ $student->submissions->where('status', '=', 'approved')->count() }}/{{ $formCount }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr style="background: rgba(0, 0, 0, 0.05);">
                <th colspan="7">Department</th>
            </tr>
            @foreach ($departments as $department)
                <tr>
                    <td>
                        <a href="{{ route('departments.courses.index', $department) }}">
                            {{ $department->name }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
