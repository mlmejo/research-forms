<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\ResearchForm;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $researchForm = ResearchForm::find($request->query('formId', 1));
        $schoolYears = Submission::distinct()->pluck('school_year');
        $department = null;
        $students = null;

        if ($request->has('departmentId')) {
            $department = Department::find($request->departmentId);
        }

        if (isset($department)) {
            $students = $department->students()->where([
                ['school_year', '=', $request->school_year],
                ['semester', '=', $request->semester],
            ])->get();
        } else {
            $students = Student::all();
        }

        return view('submissions.index', [
            'researchForm' => $researchForm,
            'students' => $students,
            'researchForms' => ResearchForm::all(),
            'departments' => Department::all(),
            'schoolYears' => $schoolYears,
        ]);
    }

    public function table(Request $request)
    {
        $request->validate([
            'formId' => 'required|exists:research_forms,id',
            'departmentId' => 'required|exists:departments,id',
            'school_year' => 'required',
            'semester' => 'required',
        ]);

        $department = Department::find($request->departmentId);

        $students = $department->students()->where(
            ['school_year' => $request->school_year],
            ['semester' => $request->semester],
        )->get();

        return view('submissions.partial.table', [
            'students' => $students,
            'formId' => $request->formId,
        ]);
    }

    public function create(ResearchForm $researchForm): View | RedirectResponse
    {
        $student = Student::where('user_id', '=', Auth::id())->first();
        $submission = $student->submissions->where('research_form_id', '=', $researchForm->id)
            ->first();

        if ($submission && $submission->status != 'rejected') {
            return back()->with([
                'message' => 'You already made a submission.',
            ]);
        }

        return view('submissions.create', ['researchForm' => $researchForm]);
    }

    public function store(Request $request, ResearchForm $researchForm): RedirectResponse
    {
        $request->validate([
            'document' => 'required|file|mimetypes:application/pdf',
            'school_year' => 'required|string',
            'semester' => [
                'required',
                Rule::in(['1st semester', '2nd semester', 'Summer class']),
            ],
        ]);

        $file = $request->file('document');
        $path = $file->store('public');

        $student = Student::where('user_id', $request->user()->id)->first();

        DB::table('submissions')->insert([
            'research_form_id' => $researchForm->id,
            'student_id' => $student->id,
            'original_filename' => $file->getClientOriginalName(),
            'path' => $path,
            'school_year' => $request->school_year,
            'semester' => $request->semester,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);

        return redirect(route('research-forms.index', $student));
    }

    public function show(Student $student, ResearchForm $researchForm)
    {
        $submission = DB::table('submissions')
            ->select(
                'submissions.id',
                'submissions.path',
                'submissions.status',
                'submissions.remark',
            )
            ->where([
                'student_id' => $student->id,
                'research_form_id' => $researchForm->id,
            ])
            ->join('research_forms', 'research_form_id', '=', 'research_forms.id')
            ->join('students', 'student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->first();

        $uri = '';

        if (isset($submission)) {
            $uri = asset('storage/' . explode('/', $submission->path)[1]);
        }

        return view('submissions.show', [
            'researchForm' => $researchForm,
            'student' => $student,
            'submission' => $submission,
            'uri' => $uri,
        ]);
    }

    public function edit(ResearchForm $researchForm)
    {
        $student = Student::where('user_id', '=', Auth::id())->first();
        $submission = $student->submissions->where('research_form_id', '=', $researchForm->id)
            ->first();

        if ($submission && $submission->status != 'rejected') {
            return back()->with([
                'message' => 'You already made a submission.',
            ]);
        }

        return view('submissions.edit', ['researchForm' => $researchForm]);
    }

    public function update(Request $request, ResearchForm $researchForm)
    {
        $student = Student::where('user_id', '=', Auth::id())->first();
        $submission = $student->submissions->where('research_form_id', '=', $researchForm->id)
            ->first();

        if ($submission && $submission->status != 'rejected') {
            return back()->with([
                'message' => 'You already made a submission.',
            ]);
        }

        $request->validate([
            'document' => 'required|file|mimetypes:application/pdf',
            'school_year' => 'required|string',
            'semester' => [
                'required',
                Rule::in(['1st semester', '2nd semester', 'Summer class']),
            ],
        ]);

        $file = $request->file('document');
        $path = $file->store('public');

        $submission = Submission::where('research_form_id', '=', $researchForm->id)
            ->where('student_id', '=', $student->id)
            ->first();

        $submission->update([
            'school_year' => $request->school_year,
            'semester' => $request->semester,
            'original_filename' => $file->getClientOriginalName(),
            'path' => $path,
            'status' => 'pending',
            'remarks' => '',
        ]);

        return redirect(route('research-forms.index', $student))
            ->with(['message' => 'Submission updated successfully.']);
    }
}
