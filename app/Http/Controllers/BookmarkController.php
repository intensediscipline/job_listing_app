<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // @desc get all users bookmarks
    // @route GET /bookmarks
    public function index(): View
    {
        // get user
        $user = Auth::user();

        //get bookmarks
        $bookmarks = $user->bookmarkedJobs()->paginate(9);

        return view("jobs.bookmarked")->with('bookmarks', $bookmarks);
    }
}
