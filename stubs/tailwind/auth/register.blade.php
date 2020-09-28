<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div class="px-4 py-4 sm:mx-auto sm:w-full sm:max-w-lg sm:shadow sm:bg-gray-50 sm:rounded-lg sm:px-10">
        <form method="POST" action="{{ route('register') }}" class="mb-4 space-y-1">
            @csrf

            <div class="space-y-1">
                <label for="name" class="text-gray-500">{{ __('Name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="space-y-1">
                <label for="email" class="text-gray-500">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="space-y-1">
                <label for="password" class="text-gray-500">{{ __('Password') }}</label>
                <input type="password" name="password" required autocomplete="new-password"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="space-y-1">
                <label for="password_confirmation" class="text-gray-500">{{ __('Confirm Password') }}</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

        </form>
    </div>
</x-layouts.guest>
