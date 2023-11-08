@if(!$emails->isEmpty())
    <div class="border border-solid dark:bg-gray-700 border-gray-600 p-5 rounded my-5">
        <h3 class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100 ">Your Email Accounts</h3>
        <div class="py-1 my-2 dark:text-gray-100 flex">
            <div>
                {{$primaryEmail}}
            </div>
            <div style="margin-left: auto;" class="text-gray-500 text-xs">
                Primary
            </div>
        </div>
        @foreach($emails as $email)
        <div class="py-1 my-2 dark:text-gray-300 flex">
            <div>
                {{$email['email']}}
            </div>
            <!-- Icons -->
            <div style="margin-left: auto;">
                <a class="" href="/delete-email-account/{{$email['id']}}">
                    <svg  class="fill-current" xmlns="http://www.w3.org/2000/svg" height="0.85em" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                </a>
            </div>
        </div>
        @endforeach
        <div style="margin-left: auto;" class="text-gray-500 text-xs">
            followup4.me will monitor these emails for new reminders
        </div>
    </div>
@else
<div class="py-1 my-2 dark:text-gray-100 flex">
    <div>
        {{$primaryEmail}}
    </div>
    <div style="margin-left: auto;" class="text-gray-500 text-xs">
        Primary
    </div>
</div>
@endif
