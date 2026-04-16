<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = FormSubmission::orderByDesc('id');
        if ($form = $request->get('form')) {
            $query->where('form_name', $form);
        }
        $submissions = $query->paginate(30)->withQueryString();
        $forms = FormSubmission::select('form_name')->distinct()->pluck('form_name');

        return view('admin.form-submissions.index', compact('submissions', 'forms'));
    }

    public function show(FormSubmission $submission)
    {
        if (! $submission->is_read) {
            $submission->update(['is_read' => true]);
        }

        return view('admin.form-submissions.show', compact('submission'));
    }

    public function destroy(FormSubmission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.form-submissions.index')->with('status', 'Envío eliminado.');
    }
}
