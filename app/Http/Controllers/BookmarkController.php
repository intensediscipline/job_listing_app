<?php

namespace App\Http\Controllers;


use App\Models\Job;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class BookmarkController extends Controller
{
    // @desc get all users bookmarks
    // @route GET /bookmarks
    public function index(): View
    {
        // get user
        $user = Auth::user();

        //get bookmarks
        $bookmarks = $user->bookmarkedJobs()->orderBy('job_user_bookmarks.created_at', 'desc')->paginate(9);

        return view("jobs.bookmarked")->with('bookmarks', $bookmarks);
    }

    // @desc create new bookmarked job 
    // @route POST /bookmarks/{job}
    public function store(Job $job): RedirectResponse
    {
        // get user
        $user = Auth::user();

        // check if the job is already bookmarked
        if ($user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('status', 'The job is already bookmarked');
        }

        // store the user bookmark in the bookmarks table
        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('success', 'Job bookmarked successfully!');
    }
}
