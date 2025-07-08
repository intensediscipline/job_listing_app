<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // @desc update profile info
    // @route PUT /profile
    public function update(Request $request): RedirectResponse
    {
        // get the logged in user
        $user = Auth::user();

        $validatedData = $request->validate([
            "name" => "required|string",
            "email" => "required|string|email",
        ]);

        $user->update($validatedData);

        return redirect()->route("dashboard")->with("success", "You have successfully updated your profile!");
    }
}
