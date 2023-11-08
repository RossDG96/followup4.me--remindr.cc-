<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <strong>Subject:</strong> <span class="font-thin">{{$subject}}</span>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-end">
                            <div><a href="/email-reminder/edit/{{$id}}">@include('svg.edit')</a></div>
                        </div>
                        <div class="max-w-xl">
                                <div class="grid grid-cols-3  py-3">
                                    <div class="font-black">Subject: </div><div>{{$subject}}</div>
                                </div>
                                <div class="grid grid-cols-3   py-3">
                                    <div class="font-black my-3">Sender: </div><div>{{$sender}}</div>
                                </div>
                                <div class="grid grid-cols-3  py-3">
                                    <div class="font-black">Recipient: </div><div><a href="mailto:{{$recipient}}">{{$recipient}}</a></div>
                                </div>
                                <div class="grid grid-cols-3  py-3">
                                    <div class="grid grid-cols-3  py-3">CC'd: </div><div>{{$cc}}</div>
                                </div>
                                <div class="grid grid-cols-3  py-3">
                                    <div class="font-black">Configuration: </div><div>{{$settings}}</div>
                                </div>
                                <div class="grid grid-cols-3  py-3">
                                    <div class="font-black">Reminder Duration: </div><div>{{$reminderPeriod}}</div>
                                </div>
                                <div class="grid grid-cols-3  py-3">
                                    <div class="font-black">Email Date: </div><div>{{$emailDate}}</div>
                                </div>
                                <div class="grid grid-cols-3  py-3">
                                    <div class="font-black ">Reminder Date: </div><div>{{$reminderDate}}</div>
                                </div>
                                <div class="grid grid-cols-3 py-3">
                                    <div class="font-black">Archived: </div><div>{{$archive}}</div>
                                </div>
                                <div class="grid grid-cols-3 py-3">
                                    <div class="font-black">Sent: </div><div>{{$sent}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>