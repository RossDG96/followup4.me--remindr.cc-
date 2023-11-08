<?php

namespace App\Http\Controllers;

use App\Models\userEmail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Delete an Email ACCOUNT from the users account
     */
    public function deleteEmail(userEmail $userEmail){
        $userEmail->delete();
        return redirect('/profile#add-new-email-account')->with('success','Successfully deleted email account.');
    }
    
    /**
     * Add a new email ACCOUNT to the users account
     */
    public function addEmail(Request $request){

        //Check if input is email address
        $incomingFields = $request->validate([
            'email' => ['required', 'email']
        ]);

        // Get all conflicting emails. 
        $existingEmails = DB::table('user_emails')
        ->where('email','=', $incomingFields['email'])
        ->get();
        
        // If the email exists in the DB or the Email is the same as the currently logged in user they can't add a new email. 
        if(count($existingEmails) >= 2 || $incomingFields['email'] == auth()->user()->email){
            return redirect('/profile')->with('failure','This email already exists.');
        }else{

        //Assign user_id to the currently logged in user
        $incomingFields['user_id'] = auth()->id();

        //Create a new userEmail in the DB
        userEmail::create($incomingFields);

        //Redirect to profile
        return redirect('/profile')->with('success','You have added a new email');
        }
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {   
        return view('profile.edit', [
            'user' => $request->user(),
            'emails' => $request->user()->userEmails,
            'primaryEmail' => auth()->user()->email
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
