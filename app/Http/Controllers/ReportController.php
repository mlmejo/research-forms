<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Student;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index', [
            'departments' => Department::all(),
            'courses' => Course::all(),
            'students' => Student::where('is_leader', '=', '1')->get(),
        ]);
    }
}
