<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubmissionStatusController extends Controller
{
    public function __invoke(Request $request, Submission $submission): RedirectResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['approved', 'rejected'])],
            'remark' => 'sometimes',
        ]);

        if ($request->status == 'approved') {
            $request->update(['remark' => '']);
        }

        $submission->update($request->only('status'));

        if ($request->remark && $request->status == 'rejected') {
            $submission->update($request->only('remark'));
        }

        return redirect(route('research-forms.submissions.show', [
            'student' => $submission->student->id,
            'research_form' => $submission->researchForm->id,
        ]));
    }
}
