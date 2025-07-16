<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Applicant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ApplicantController extends Controller
{
    // @desc store new job application
    // @route /jobs/{job}/apply
    public function store(Job $job, Request $request)
    {
        // check if user has already applied
        // get existng application
        $existingApplication = Applicant::where('job_id', $job->id)->where('user_id', auth()->user()->id)->exists();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this job');
        }

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

    // @desc delete applicant
    // @route /applicants/{applicant}
    public function destroy($id): RedirectResponse
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->delete();

        return redirect()->route('dashboard')->with('success', 'Applicant deleted successfully!');
    }
}
