<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function showAllReminders() {
        
        //Get all of a users email accounts
        $allUserEmailAccounts = DB::table('user_emails')->where('user_id','=',auth()->user()->id)->get();
        $allUserEmails = [];
        foreach($allUserEmailAccounts as $account){
            $email = $account->email;
            $newRecords = json_decode(DB::table('emails')->where('sender','=',$email)->get());
            $allUserEmails = array_merge($allUserEmails,$newRecords);
        }

        //Get current actual logged in user emails
        $userEmail = auth()->user()->email;
        $primaryAccountEmails = json_decode(DB::table('emails')->where('sender','=',$userEmail)->get());
        $allUserEmails = array_merge($allUserEmails,$primaryAccountEmails);

        return $allUserEmails;
    }
    function returnDashboard() {

        // Return Primary Account Emails
        $userID = auth()->user()->id;
        $user = User::find($userID);
        $allUserEmails = [];
        $allUserArchivedEmails = [];
        
        $userEmailReminders = json_decode(DB::table('emails')
        ->where('sender','=',$user->email)
        ->where('archive','=',0)
        ->get());

        $allUserEmails = array_merge($allUserEmails,$userEmailReminders);

        //Get all of a users email accounts
        $allUserEmailAccounts = DB::table('user_emails')->where('user_id','=',auth()->user()->id)->get();
        if(count($allUserEmailAccounts) > 0){
            
            foreach($allUserEmailAccounts as $account){
            $email = $account->email;
            $newRecords = json_decode(DB::table('emails')
                ->where('sender','=',$email)
                ->where('archive','=',0)
                ->get());
            $allUserEmails = array_merge($allUserEmails,$newRecords);
            }
        }

        $userEmailRemindersCount = count($allUserEmails); 

        // Get Archived Emails
        $archivedEmailReminders = json_decode(DB::table('emails')
        ->where('sender','=',$user->email)
        ->where('archive','=',1)
        ->get());

        $allUserArchivedEmails = array_merge($allUserArchivedEmails,$archivedEmailReminders);

        // Get All Acount Archived Emails
        if(count($allUserEmailAccounts) > 0){
            foreach($allUserEmailAccounts as $account){
            $archivedEmail = $account->email;
            $newArchivedRecords = json_decode(DB::table('emails')
                ->where('sender','=',$archivedEmail)
                ->where('archive','=',1)
                ->get());
            $allUserArchivedEmails = array_merge($allUserArchivedEmails,$newArchivedRecords);
            }
        }

        $archivedEmailsCount = count($allUserArchivedEmails);

       return view('dashboard',
        [
            'name'=>auth()->user()->name,
            'email'=>auth()->user()->email,
            'emailReminders' => $allUserEmails,
            'count' => $userEmailRemindersCount,
            'archivedEmails' => $allUserArchivedEmails,
            'arhivedEmailsCount' => $archivedEmailsCount
        ])
        ->with('success', 'Welcome ' . auth()->user()->name . ' :)'); 
       
    }
}
