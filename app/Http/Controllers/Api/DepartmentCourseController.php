<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentCourseController extends Controller
{
    public function index(Department $department)
    {
        return response()->json($department->courses);
    }
}
