<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $jobs = Job::where("user_id", $user->id)->with('applicants')->get();

        //dd($jobs);

        return view("dashboard.index", compact("user", "jobs"));
    }
}
