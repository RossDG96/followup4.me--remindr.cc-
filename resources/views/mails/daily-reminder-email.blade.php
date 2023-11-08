<div>
    <p>Hi <strong>{{$payload['from']}}</strong>, reminder about the following:</p>
    
    <p>
    <strong>Subject:</strong> {{$payload['subject']}}<br>
    <strong>To:</strong> {{$payload['to']}}<br>
    </p>

    <p>Regards,<br>
    The followup4.me team<br>
    </p>
    <br>
    <hr>
    <br>
    <a href="https://remindr.cc/dashboard">My Dashboard</a><br>
    <a href="https://remindr.cc/email-reminder/{{$payload['emailID']}}">View Reminder</a><br>
</div>