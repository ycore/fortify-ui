<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />
    @php
        // EXAMPLE: Rendering the two-factor-challenge UI - a simple example of toggling challenge codes
        // You [c|sh]ould also implement it using a service class, controller, javascript etc.

        if (session()->has('request-two-factor-auth-code')) {
            session()->forget('request-two-factor-auth-code');
        } else {
            session()->put('request-two-factor-auth-code', 'true');
        }
    @endphp
    <div>
    <div>
        @foreach (json_decode(decrypt(App\Models\User::find(1)->two_factor_recovery_codes), true) as $code)
        <div>{{ $code }}</div>
        @endforeach
    </div>

        <form method="POST" action="{{ url('/two-factor-challenge') }}">
            @csrf
            @if (session()->has('request-two-factor-auth-code'))
            <div>
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator
                application.') }}
            </div>

            <div>
                <label for="code">{{ __('Authentication code') }}</label>
                <input type="text" name="code" autofocus autocomplete="one-time-code" />
            </div>
            @else
            <div>
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <div>
                <label for="code">{{ __('Recovery code') }}</label>
                <input type="text" name="recovery_code" autofocus autocomplete="one-time-code" />
            </div>
            @endif
            <div>
                @if (Route::has('two-factor.login'))
                <a href="{{ route('two-factor.login') }}">
                    @if (session()->has('request-two-factor-auth-code'))
                        {{ __('Use a recovery code') }}
                    @else
                        {{ __('Use an authentication code') }}
                    @endif
                </a>
                @endif

                <div>
                    <button type="submit">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.guest>
