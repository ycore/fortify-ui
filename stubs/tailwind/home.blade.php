<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />
    <div class="fixed top-0 right-0 flex items-center justify-end px-4 py-2 space-x-4">
        <div class="text-gray-800">
            {{ auth()->user()->name }}
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-gray-700 uppercase hover:underline hover:text-blue-700">
                {{ __('Logout') }}
            </button>

        </form>
    </div>
</x-layouts.guest>
