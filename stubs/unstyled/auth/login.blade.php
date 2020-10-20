<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" />
            </div>

            <div>
                <label for="password">{{ __('Password') }}</label>
                <input type="password" name="password" required autocomplete="current-password" />
            </div>

            <div>
                <div>
                    <input type="checkbox" name="remember">
                    <label for="remember_me">{{ __('Remember me') }}</label>
                </div>

                <button type="submit">
                    {{ __('Login') }}
                </button>
            </div>

            <div>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
                @if (Route::has('register'))
                <a href="{{ route('register') }}">
                    {{ __('Not registered?') }}
                </a>
                @endif
            </div>

        </form>
    </div>
</x-layouts.guest>
