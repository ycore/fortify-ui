<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div class="px-4 py-4 sm:mx-auto sm:w-full sm:max-w-lg sm:shadow sm:bg-gray-50 sm:rounded-lg sm:px-10">

        <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mb-4 space-y-2">
            @csrf
            <div class="my-2 text-sm text-gray-500">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator
                application.') }}
            </div>

            <div class="flex items-start space-x-2">
                <label for="code" class="text-gray-500">{{ __('Authentication code') }}</label>
                <input type="text" name="code" autofocus autocomplete="one-time-code"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

        </form>
    </div>
</x-layouts.guest>
