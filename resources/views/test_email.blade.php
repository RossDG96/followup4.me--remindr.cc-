<div>
    <p>Hi <strong>{{$payload['from']}}</strong></p>

    <p>Here are the details:<br>
    <strong>Subject:</strong> {{$payload['subject']}}<br>
    <strong>To:</strong> {{$payload['to']}}<br>
    </p>

    <p>You have requested a reminder in <strong>{{$payload['duration']}} days</strong>. See you then! (<strong>{{$payload['date']}}</strong>)</p>
    
    <p>Regards,<br>
    The followup4.me team<br>
    </p>
    <br>
    <hr>
    <br>
    <a href="https://remindr.cc/email-reminder/snooze/{{$payload['emailID']}}">Snooze This Reminder</a><br>
    <a href="https://remindr.cc/email-reminder/reminder-confirmations/{{$payload['emailID']}}">Disable reminder confirmations</a><br>
    <a href="https://remindr.cc/dashboard">My Dashboard</a><br>
    <a href="https://remindr.cc/email-reminder/{{$payload['emailID']}}">View Reminder</a><br>
    <a href="https://remindr.cc/email-reminder/edit/{{$payload['emailID']}}">Edit Reminder</a><br>
</div>