<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Job;
use App\models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobController extends Controller
{
    use AuthorizesRequests;
    public function index(): View
    {
        $jobs = Job::latest()->paginate(9);

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //dd($request->file('company_logo'));
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'nullable|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url'
        ]);

        // user id is now the logged in user
        $validatedData['user_id'] = auth()->user()->id;

        // check for file
        if ($request->hasFile('company_logo')) {

            // store the file and get path
            $path = $request->file('company_logo')->store('logos', 'public');

            // add path to validated data
            $validatedData['company_logo'] = $path;
        }

        Job::create($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job listing created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job): View
    {
        return view('jobs.show')->with(['job' => $job]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job): View
    {
        // check if user is authorised
        $this->authorize('update', $job);

        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        // check if user is authorised
        $this->authorize('update', $job);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'nullable|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url'
        ]);

        // check for file
        if ($request->hasFile('company_logo')) {

            // Delete old logo
            //Storage::delete('public/logos' . basename($job->company_logo));
            Storage::disk('public')->delete($job->company_logo);


            // store the file and get path
            $path = $request->file('company_logo')->store('logos', 'public');

            // add path to validated data
            $validatedData['company_logo'] = $path;
        }

        $job->update($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job listing updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job): RedirectResponse
    {
        // check if user is authorised
        $this->authorize('delete', $job);
        // if logo then delete it
        if ($job->company_logo) {
            //Storage::delete('public/logos' . $job->company_name);
            Storage::disk('public')->delete($job->company_logo);

        }

        $job->delete();

        // check if request came from the dashboard
        if (request()->query('from') == 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Job listing deleted successfully!');
        }

        return redirect()->route('jobs.index')->with('success', 'Job listing deleted successfully!');
    }
}
