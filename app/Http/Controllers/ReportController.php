<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\ResearchForm;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::all();

        if ($request->has(['school_year', 'semester'])) {
            $students = Student::whereHas('submissions', function ($query) use ($request) {
                $query->where(function ($subquery) use ($request) {
                    $subquery->where('school_year', '=', $request->input('school_year'))
                        ->where('semester', '=', $request->input('semester'));
                });
            })->get();
        }

        return view('reports.index', [
            'students' => Student::all(),
            'formCount' => ResearchForm::count(),
            'schoolYears' => Submission::distinct()->pluck('school_year'),
            'departments' => Department::all(),
        ]);
    }

    public function table(Request $request)
    {
        $request->validate([
            'school_year' => 'required',
            'semester' => 'required',
        ]);

        $students = Student::whereHas('submissions', function ($query) use ($request) {
            $query->where([
                'school_year' => $request->school_year,
                'semester' => $request->semester,
            ]);
        })->get();

        return view('reports.partial.table', [
            'students' => $students,
            'formCount' => ResearchForm::count(),
            'departments' => Department::all(),
        ]);
    }
}
