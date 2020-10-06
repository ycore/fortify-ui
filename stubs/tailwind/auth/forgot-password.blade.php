<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div class="px-4 py-4 sm:mx-auto sm:w-full sm:max-w-lg sm:px-0">

        <div class="my-4 text-xs text-justify text-gray-400 sm:text-sm">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="flex items-start space-x-2">
                <label for="email" class="text-gray-500">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="flex items-end justify-between">
                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="text-blue-600 transition duration-150 ease-in-out hover:text-blue-400 focus:outline-none focus:underline">
                    {{ __('Not registered?') }}
                </a>
                @endif

                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="flex justify-center px-2 py-2 text-white transition duration-300 ease-in-out bg-blue-500 border border-blue-600 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline active:bg-blue-700">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</x-layouts.guest>
