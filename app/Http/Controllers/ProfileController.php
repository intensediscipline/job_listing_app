<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Log;

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
            'profile_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // check for file
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Log::info('deleted public/' . $user->profile_image);
                Storage::disk('public')->delete($user->profile_image);
            }
            // store the file and get path
            //$path = $request->file('profile_image')->store('profile_images', 'public');
            $path = $validatedData['profile_image']->store('profile_images', 'public');

            // add path
            $user->profile_image = $path;

            $user->save();
        }

        return redirect()->route("dashboard")->with("success", "You have successfully updated your profile!");
    }
}
