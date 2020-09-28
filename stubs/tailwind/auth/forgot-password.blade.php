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

        </form>
    </div>
</x-layouts.guest>
