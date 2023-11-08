<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('success'))
                    <div class="p-6 text-green-900 bg-green-400 border-1 border-solid border-green-900 shadow-inner">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if(session('failure'))
                    <div class="p-6 text-red-900 bg-red-400 border-1 border-solid border-red-900 shadow-inner">
                        <div class="alert alert-danger">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="my-5 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($count < 1)
                    <div class="text-gray-900 dark:text-gray-100">
                        BCC <strong>1@remindr.cc</strong> to start seeing reminders here
                    </div>
                    @else
                        <h2 class="text-2xl font-black">Your Email Reminders</h2>
                        <p class="mb-5 text-gray-500">For: {{$email}}</p>
                        <div class="grid">
                            <div class="grid font-black" style="grid-template-columns: 1fr 1fr 1fr 150px 150px 50px 50px 50px;">
                                <div class="flex content-center">Subject</div>
                                <div class="flex content-center">From</div>
                                <div class="flex content-center">Recipient</div>
                                <div class="flex content-center">Sent Date</div>
                                <div class="flex content-center">Reminder Date</div>
                                <div class="flex justify-center content-center">@include('svg.duration')</div>
                                <div class="flex justify-center content-center">@include('svg.send')</div>
                                <div class="flex justify-center content-center">@include('svg.edit')</div>
                            </div>
                            
                            @foreach($emailReminders as $reminder)
                            <div class="grid text-gray-400 divide-y divide-gray-400" style="grid-template-columns: 1fr 1fr 1fr 150px 150px 50px 50px 50px;">
                                <div class="py-3">
                                    <a href="/email-reminder/{{$reminder->id}}">{{$reminder->subject}}</a>
                                </div>
                                <div class="py-3">
                                    <a href="/email-reminder/{{$reminder->id}}">{{$reminder->sender}}</a>
                                </div>
                                <div class="py-3">
                                    <a href="mailto:{{$reminder->recipient}}">
                                        {{$reminder->recipient}}
                                    </a>
                                </div>
                                <div class="py-3">{{$reminder->email_date}}</div>
                                <div class="py-3">{{$reminder->reminder_date}}</div>
                                <div class="flex justify-center content-center py-3">{{$reminder->reminder_period}}</div>
                                @if($reminder->sent == 1)
                                    <div class="flex justify-center content-center py-3 text-green-400">@include('svg.check')</div>
                                @else
                                    <div class="flex justify-center content-center py-3 text-red-400">@include('svg.cross')</div>
                                @endif
                                <div class="flex justify-center content-center py-3">
                                    <a href="/email-reminder/archive/{{$reminder->id}}">@include('svg.archive')</a>
                                    &nbsp;&nbsp;
                                    <a href="/email-reminder/snooze/{{$reminder->id}}">@include('svg.snooze')</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                    
                    @if($arhivedEmailsCount > 0)
                        <h2 class="text-2xl font-black mt-10">Your Archived Emails</h2>
                        <p class="mb-5 text-gray-500">For: {{$email}}</p>
                        <div class="grid">
                            <div class="grid font-black" style="grid-template-columns: 1fr 1fr 1fr 150px 150px 50px 50px 50px;">
                                <div class="flex content-center">Subject</div>
                                <div class="flex content-center">From</div>
                                <div class="flex content-center">Recipient</div>
                                <div class="flex content-center">Sent Date</div>
                                <div class="flex content-center">Reminder Date</div>
                                <div class="flex justify-center content-center">@include('svg.duration')</div>
                                <div class="flex justify-center content-center">@include('svg.send')</div>
                                <div class="flex justify-center content-center">@include('svg.edit')</div>
                            </div>
                            
                            @foreach($archivedEmails as $reminder)
                            <div class="grid text-gray-400 divide-y divide-gray-400" style="grid-template-columns: 1fr 1fr 1fr 150px 150px 50px 50px 50px;">
                                <div class="py-3">{{$reminder->subject}}</div>
                                <div class="py-3">
                                    <a href="/email-reminder/{{$reminder->id}}">{{$reminder->sender}}</a>
                                </div>
                                <div class="py-3">
                                    <a href="mailto:{{$reminder->recipient}}">
                                        {{$reminder->recipient}}
                                    </a>
                                </div>
                                <div class="py-3">{{$reminder->email_date}}</div>
                                <div class="py-3">{{$reminder->reminder_date}}</div>
                                <div class="flex justify-center content-center py-3">{{$reminder->reminder_period}}</div>
                                    @if($reminder->sent == 1)
                                        <div class="flex justify-center content-center py-3 text-green-400">@include('svg.check')</div>
                                    @else
                                        <div class="flex justify-center content-center py-3 text-red-400">@include('svg.cross')</div>
                                    @endif
                                <div class="flex justify-center content-center py-3">
                                        <a href="/email-reminder/unarchive/{{$reminder->id}}">@include('svg.archive')</a>
                                        &nbsp; &nbsp;
                                        <a class="text-red-500" href="/email-reminder/delete/{{$reminder->id}}">@include('svg.trash')</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
