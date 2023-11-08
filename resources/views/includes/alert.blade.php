
    @if(session('success'))
    <div class="p-4 sm:p-8 text-green-900 bg-green-400 border-1 border-solid border-green-900 shadow-inner shadow sm:rounded-lg">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('failure'))
        <div class="p-4 sm:p-8 text-red-900 bg-red-400 border-1 border-solid border-red-900 shadow-inner shadow sm:rounded-lg">
            <div class="alert alert-danger">
                {{ session('failure') }}
            </div>
        </div>
    @endif
