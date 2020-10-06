<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div class="px-4 py-4 sm:mx-auto sm:w-full sm:max-w-lg sm:shadow sm:bg-gray-50 sm:rounded-lg sm:px-10">
        <form method="POST" action="{{ route('login') }}" class="mb-4 space-y-2">
            @csrf

            <div class="space-y-1">
                <label for="email" class="text-gray-500">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="space-y-1">
                <label for="password" class="text-gray-500">{{ __('Password') }}</label>
                <input type="password" name="password" required autocomplete="current-password"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="flex items-end justify-between py-2">
                <div class="flex items-center">
                    <input type="checkbox" name="remember"
                        class="w-4 h-4 text-blue-500 transition duration-150 ease-in-out focus:outline-none focus:shadow-outline focus:border-blue-300">
                    <label for="remember_me" class="ml-2 text-gray-500 ">{{ __('Remember me') }}</label>
                </div>

                <button type="submit"
                    class="flex justify-center w-1/2 py-2 text-white transition duration-300 ease-in-out bg-blue-500 border border-blue-600 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline active:bg-blue-700">
                    {{ __('Login') }}
                </button>
            </div>

            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-blue-600 transition duration-150 ease-in-out hover:text-blue-400 focus:outline-none focus:underline">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="text-blue-600 transition duration-150 ease-in-out hover:text-blue-400 focus:outline-none focus:underline">
                    {{ __('Not registered?') }}
                </a>
                @endif
            </div>

        </form>
    </div>
</x-layouts.guest>
