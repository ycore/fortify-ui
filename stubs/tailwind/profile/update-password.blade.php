<div class="sm:mx-auto sm:w-full sm:max-w-lg">
    <h2 class="mb-4 font-semibold text-blue-400 uppercase">Update Password</h2>
    <div class="px-4 py-4 sm:shadow sm:bg-gray-50 sm:rounded-lg sm:px-10">
        <form method="POST" action="{{ route('user-password.update') }}">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label for="password" class="text-gray-500">{{ __('Current Password') }}</label>
                <input type="password" name="current_password" required autocomplete="current-password"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="space-y-1">
                <label for="password" class="text-gray-500">{{ __('New Password') }}</label>
                <input type="password" name="password" required autocomplete="new-password"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="space-y-1">
                <label for="password" class="text-gray-500">{{ __('Confirm Password') }}</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit"
                    class="flex justify-center w-1/2 py-2 text-white transition duration-300 ease-in-out bg-blue-500 border border-blue-600 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline active:bg-blue-700">
                    {{ __('Update Password') }}
                </button>
            </div>

        </form>
    </div>
</div>
