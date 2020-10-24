<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />
    @php
        // EXAMPLE: Rendering the two-factor-challenge UI - a simple example of toggling challenge codes
        // You [c|sh]ould also implement it using a service class, controller, javascript etc.

        if (session()->has('request-two-factor-auth-code')) {
            session()->forget('request-two-factor-auth-code');
        } else {
            session()->put('request-two-factor-auth-code', 'true');
        }
    @endphp
    <div class="px-4 py-4 sm:mx-auto sm:w-full sm:max-w-lg sm:shadow sm:bg-gray-50 sm:rounded-lg sm:px-10">
    <div class="my-4 text-xs text-gray-600">
        @foreach (json_decode(decrypt(App\Models\User::find(1)->two_factor_recovery_codes), true) as $code)
        <div>{{ $code }}</div>
        @endforeach
    </div>

        <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mb-4 space-y-2">
            @csrf
            @if (session()->has('request-two-factor-auth-code'))
            <div class="my-2 text-sm text-gray-500">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator
                application.') }}
            </div>

            <div class="flex items-start space-x-2">
                <label for="code" class="text-gray-500">{{ __('Authentication code') }}</label>
                <input type="text" name="code" autofocus autocomplete="one-time-code"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>
            @else
            <div class="my-2 text-sm text-gray-500">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <div class="flex items-start space-x-2">
                <label for="code" class="text-gray-500">{{ __('Recovery code') }}</label>
                <input type="text" name="recovery_code" autofocus autocomplete="one-time-code"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>
            @endif
            <div class="flex items-end justify-between">
                @if (Route::has('two-factor.login'))
                <a href="{{ route('two-factor.login') }}"
                    class="text-blue-600 transition duration-150 ease-in-out hover:text-blue-400 focus:outline-none focus:underline">
                    @if (session()->has('request-two-factor-auth-code'))
                        {{ __('Use a recovery code') }}
                    @else
                        {{ __('Use an authentication code') }}
                    @endif
                </a>
                @endif

                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="flex justify-center px-4 py-2 text-white transition duration-300 ease-in-out bg-blue-500 border border-blue-600 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline active:bg-blue-700">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.guest>
