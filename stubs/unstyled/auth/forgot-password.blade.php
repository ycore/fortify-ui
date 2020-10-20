<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div>

        <div>
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <label for="email">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus />
            </div>

            <div>
                @if (Route::has('register'))
                <a href="{{ route('register') }}">
                    {{ __('Not registered?') }}
                </a>
                @endif

                <div>
                    <button type="submit">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</x-layouts.guest>
