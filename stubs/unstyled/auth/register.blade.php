<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            </div>

            <div>
                <label for="email">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
            </div>

            <div>
                <label for="password">{{ __('Password') }}</label>
                <input type="password" name="password" required autocomplete="new-password" />
            </div>

            <div>
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div>
                @if (Route::has('login'))
                <a href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                @endif

                <button type="submit">
                    {{ __('Register') }}
                </button>
            </div>

        </form>
    </div>
</x-layouts.guest>
