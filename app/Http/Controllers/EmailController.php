<?php

namespace App\Http\Controllers;

use App\Mail\test;
use App\Models\User;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AccountSettings;

class EmailController extends Controller
{
    public function sendEmailreminders(){
        
    }
    public function toggleReminderConfirmations(Request $request){
        $id = $request['id'];
        return $id; 
    }
    public function editEmailReminder(Request $request){
        $id = $request['id'];
        $reminder = Email::find($id);

        return view('edit-email-reminder',[
            'id' => $reminder['id'],
            'sender' => $reminder['sender'],
            'recipient' => $reminder['recipient'],
            'settings' => $reminder['settings'],
            'subject' => $reminder['subject'],
            'emailDate' => $reminder['email_date'],
            'reminderDate' => $reminder['reminder_date'],
            'reminderPeriod' => $reminder['reminder_period'],
            'archive' => $reminder['archive'],
            'cc' => $reminder['cc'],
            'sent' => $reminder['sent']
        ]);
    }
    public function viewEmailReminder(Request $request){
        $id = $request['id'];
        $reminder = Email::find($id);

        return view('view-email-reminder',[
            'id' => $reminder['id'],
            'sender' => $reminder['sender'],
            'recipient' => $reminder['recipient'],
            'settings' => $reminder['settings'],
            'subject' => $reminder['subject'],
            'emailDate' => $reminder['email_date'],
            'reminderDate' => $reminder['reminder_date'],
            'reminderPeriod' => $reminder['reminder_period'],
            'archive' => $reminder['archive'],
            'cc' => $reminder['cc'],
            'sent' => $reminder['sent']
        ]);
    }

    public function snoozeEmailReminder(Request $request){
        $AccountSettings = app(AccountSettings::class);
        $snoozeDuration = $AccountSettings->defaultSnoozeDuration();

        $reminder = Email::find($request['id']);
        $date = $reminder->reminder_date;
        $reminder->reminder_period = $reminder->reminder_period + $snoozeDuration;
        $reminder->reminder_date = date('Y-m-d', strtotime($date. ' + ' . $snoozeDuration .  'days'));
        $reminder->save();

        return back()->with('success','Reminder successfully snoozed for ' . $snoozeDuration . ' days.');
    }

    public function deleteEmailReminder(Request $request){
        $emailID = $request['id'];
        $email = Email::find($emailID);
        $subject = $email->subject;
        $email->delete();

        return redirect('dashboard')->with('success', $subject . ' successfully deleted.');
    }

    public function unarchiveEmailReminder(Request $request){
        $emailID = $request['id'];
        $email = Email::find($emailID);
        $email->archive = 0; 
        $email->save();

        $subject = $email->subject;
        
        return redirect('dashboard')->with('success', '"' . $subject . '" has been archived.');
    }

    public function archiveEmailReminder(Request $request){

        $emailID = $request['id'];
        $email = Email::find($emailID);
        $email->archive = 1; 
        $email->save();

        $subject = $email->subject;
        
        return redirect('dashboard')->with('success', '"' . $subject . '" has been archived.');
    }   

    public function receiveEmailsFromSendGrid(Request $request){

        $keyEmail = "remindr.cc"; //This is the address that the Send Grid parser is listening to

        $envelope = $request->input("envelope"); //This is an array containing "To:" (which can also be BCC recipient) and from (who sent the mail.)
        $obj = json_decode($envelope);

        $from = $obj->from;
        $to = $request->input("to");
        $cc = $request->input("cc");
        $bcc = $obj->to[0];
        $subject = $request->input("subject");

        // Get User ID
        $user = User::where('email',$from)->first();
        if($user){
            $userID = $user->id;
        }else{
            $userID = 0; 
        }

        // Validate fields
        if(!$cc){
            $cc = "none";
        }

        //fix emails with "YOUR NAME HERE <email@gmail.com>" 
        if(str_contains($to,"<") && str_contains($to,">")){
            preg_match_all('/(?:<)(.*@.*)(?:>)/',$to,$matches);
            $to = $matches[1][0];
        }
        
        // Calculate Reminder Duration
        $date = date("Y-m-d");
        preg_match_all('/(\d*)(?:@' . $keyEmail .')/i',$bcc,$matches);
        $duration = $matches[1][0];
        Log::info(print_r($matches,true));
        $reminderDate = date('Y-m-d', strtotime($date. ' + ' . $duration .  'days'));

        // Enter Email into DB
        $newEmail = Email::create(
            [
            'sender' => $from,
            'recipient'=> $to,
            'cc' => $cc,
            'settings' => $bcc,
            'subject' => $subject, 
            'email_date' => $date,
            'reminder_date' => $reminderDate, 
            'reminder_period' => $duration,
            'archive' => 0, //Archive is false by default
            'user_id' => $userID
            ]
        );

        $emailID = $newEmail->id;

        $payload = [
            'from' => $from,
            'to'=> $to,
            'cc' => $cc,
            'bcc' => $bcc,
            'subject' => $subject, 
            'date' => $date,
            'reminderDate' => $reminderDate, 
            'duration' => $duration,
            'userID' => $userID,
            'emailID' => $emailID
        ];

        // Log the payload for testing reasons
        Log::info(print_r($payload, true));

        // Send an email to the person who requested the email
        // Perhaps change this to a queued task? 
        Mail::to($from)->send(new test($payload));

        return response()->json(["success" => true]);
        }
    
}
