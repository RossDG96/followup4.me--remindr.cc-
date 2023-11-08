<section>
    <details>
        <summary class="flex">
            <header style="user-select: none; cursor: pointer;">
                <h2 id="add-new-email-account" class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Add a new email
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    By adding a new email, you are able to view reminders for multiple emails from this account. 
                </p>
            </header>
        </summary>

    <form method="post" action="{{ route('profile.addemail') }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <x-input-label for="add_new_email" :value="__('Add New Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="test@example.com" required />
            <x-input-error :messages="$errors->addNewEmail->get('add_new_email')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'email-added')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    @include('profile.partials.show-user-emails')
    </details>
</section>