<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Applicant;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    // @desc store new job application
    // @route /jobs/{job}/apply
    public function store(Job $job, Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string',
            'contact_phone' => 'string',
            'contact_email' => 'required|string|email',
            'message' => 'string',
            'location' => 'string',
            'cv' => 'required|file|mimes:pdf|max:2048',
        ]);

        // handle cv upload
        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cv', 'public');
            $validatedData['cv_path'] = $path;
        }

        //store the application
        $application = new Applicant($validatedData);
        $application->job_id = $job->id;
        $application->user_id = auth()->id();
        $application->save();

        return redirect()->back()->with('success', 'Your application has been submitted');
    }
}
