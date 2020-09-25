<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div class="px-4 py-4 sm:mx-auto sm:w-full sm:max-w-lg sm:px-0">

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

        </form>
    </div>
</x-layouts.guest>
