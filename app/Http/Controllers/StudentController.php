<?php

namespace App\Http\Controllers;

use App\Enums\YearLevel;
use App\Models\Course;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('students.index', ['students' => Student::all()]);
    }

    public function edit(Student $student): View
    {
        return view('students.edit', [
            'student' => $student,
            'courses' => Course::all(),
            'departments' => Department::all(),
            'advisers' => User::whereHas('roles', function ($query) {
                $query->where('name', 'adviser');
            })->get(),
        ]);
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $request->validate([
            'student_id' => [
                'required',
                'string',
                Rule::unique('users', 'username')->ignore($student->user),
            ],
            'first_name' => 'required|string',
            'middle_name' => 'sometimes|required|string',
            'last_name' => 'required|string',
            'department' => 'required|string',
            'course' => 'required|string',
            'year_level' => ['required', Rule::in(array_column(YearLevel::cases(), 'value'))],
            'adviser' => 'required|string',
            'control_number' => [
                'required',
                Rule::unique('students')->ignore($student),
                'string',
            ],
            'is_leader' => ['required', Rule::in([0, 1])],
        ]);

        $student->user()->update([
            'username' => $request->student_id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
        ]);

        $student->update($request->only(
            'department',
            'course',
            'year_level',
            'adviser',
            'control_number',
            'is_leader',
        ));

        return redirect(route('students.index'))
            ->with('message', 'Student information updated successfully.');
    }
}
