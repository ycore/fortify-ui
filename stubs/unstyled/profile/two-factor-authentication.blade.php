<div>
    <h2>Two factor authentication</h2>
    <div>
        @if(! auth()->user()->two_factor_secret)
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            @csrf

            <button type="submit">
                {{ __('Enable Two-Factor Authentication') }}
            </button>
        </form>
        @else
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            @csrf
            @method('DELETE')

            <button type="submit">
                {{ __('Disable Two-Factor Authentication') }}
            </button>
        </form>

        @if(session('status') == 'two-factor-authentication-enabled')
        <div>
            {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
        </div>

        <div>
            {!! auth()->user()->twoFactorQrCodeSvg() !!}
        </div>
        @endif

        <div>
            {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
        </div>

        <div>
            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
            <div>{{ $code }}</div>
            @endforeach
        </div>

        <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
            @csrf

            <button type="submit">
                {{ __('Regenerate Recovery Codes') }}
            </button>
        </form>
        @endif
    </div>
</div>
