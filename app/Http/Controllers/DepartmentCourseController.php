<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentCourseController extends Controller
{
    public function index(Department $department)
    {
        return view('departments.courses.index', [
            'department' => $department,
        ]);
    }
}
