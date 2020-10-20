<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />

    <div>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email', $request->email) }}" required />
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
                <button type="submit">
                    {{ __('Reset Password') }}
                </button>
            </div>

        </form>
    </div>
</x-layouts.guest>
