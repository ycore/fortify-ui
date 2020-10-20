<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <label for="password">{{ __('Password') }}</label>
                <input type="password" name="password" required autocomplete="current-password" />
            </div>

            <div>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <button type="submit">
                    {{ __('Confirm Password') }}
                </button>
            </div>

        </form>
    </div>
</x-layouts.guest>
