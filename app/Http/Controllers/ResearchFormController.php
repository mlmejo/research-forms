<?php

namespace App\Http\Controllers;

use App\Models\ResearchForm;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ResearchFormController extends Controller
{
    public function index(Student $student): View
    {
        $forms = ResearchForm::with(['submissions' => function ($query) use ($student) {
            $query->where('student_id', $student->id);
        }])->get();

        $forms->each(function ($form) {
            $form->submitted = $form->submissions->isNotEmpty();
        });

        return view('research-forms.index', [
            'researchForms' => $forms,
            'student' => $student,
        ]);
    }

    public function create()
    {
        return view('research-forms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:research_forms|string',
        ]);

        ResearchForm::create($validated);

        return redirect(route('research-forms.submissions.index'))->with([
            'message' => 'Research Form created successfully.',
        ]);
    }
}
