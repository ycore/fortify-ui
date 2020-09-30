<div class="sm:mx-auto sm:w-full sm:max-w-lg">
    <h2 class="mb-4 font-semibold text-blue-400 uppercase">Update Profile Information</h2>
    <div class="px-4 py-4 sm:shadow sm:bg-gray-50 sm:rounded-lg sm:px-10">

        <form method="POST" action="{{ route('user-profile-information.update') }}">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label for="name" class="text-gray-500">{{ __('Name') }}</label>
                <input type="text" name="name" value="{{ old('name') ?? auth()->user()->name }}" required autofocus
                    autocomplete="name"
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="space-y-1">
                <label for="email" class="text-gray-500">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') ?? auth()->user()->email }}" required autofocus
                    class="w-full px-3 py-2 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:shadow-outline focus:border-blue-300" />
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit"
                    class="flex justify-center w-1/2 py-2 text-white transition duration-300 ease-in-out bg-blue-500 border border-blue-600 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline active:bg-blue-700">
                    {{ __('Update Profile') }}
                </button>
            </div>

        </form>
    </div>
</div>
