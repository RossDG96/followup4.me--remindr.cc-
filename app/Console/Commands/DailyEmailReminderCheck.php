<?php

namespace App\Console\Commands;

use App\Models\Email;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Mail\DailyReminderEmailMail;
use Illuminate\Support\Facades\Mail;

class DailyEmailReminderCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyEmailReminderCheck'; //Dear future ross, when you're frustrated that a command is not working check that enter yor command class name here

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every morning check if a user has any email reminders. ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $todayDate = date("Y-m-d");

        // Fetch records that match the criteria
        $matchingRecords = Email::where('reminder_date', '=', $todayDate)->get();
        $count = $matchingRecords->count();


        if($count > 0){
            // Loop through the matching records
            foreach ($matchingRecords as $record) {
                //Create email data payload

                // Add email to queue

                // Access record fields using object properties
                $from = $record->sender;
                $to = $record->recipient;
                $cc = $record->cc; 
                $bcc = $record->settings;
                $subject = $record->subject;
                $date = $record->email_date;
                $reminderDate = $record->reminder_date;
                $duration = $record->reminder_period;
                $userID = $record->user_id;
                $emailID = $record->id;

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

                Mail::to($from)->send(new DailyReminderEmailMail($payload));
                Log::info("Email sent to: " . $from);

                //Update the email once it's been sent
                $email = Email::find($emailID);
                $email->sent = 1;
                $email->save();
            }
        }else{
                Log::info("No Emails Sent Today");
            }
    }
}
