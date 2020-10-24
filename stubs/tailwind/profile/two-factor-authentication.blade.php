<div class="sm:mx-auto sm:w-full sm:max-w-lg">
    <h2 class="mb-4 font-semibold text-blue-400 uppercase">Two factor authentication</h2>
    <div class="px-4 py-4 sm:mx-auto sm:w-full sm:max-w-lg sm:shadow sm:bg-gray-50 sm:rounded-lg sm:px-10">
        @if (! auth()->user()->two_factor_secret)
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            @csrf

            <button type="submit"
                class="flex justify-center px-4 py-2 text-white transition duration-300 ease-in-out bg-green-500 border border-green-600 rounded-md hover:bg-green-600 focus:outline-none focus:border-green-700 focus:shadow-outline active:bg-green-700">
                {{ __('Enable Two-Factor Authentication') }}
            </button>
        </form>
        @else
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            @csrf
            @method('DELETE')

            <button type="submit"
                class="flex justify-center px-4 py-2 text-white transition duration-300 ease-in-out bg-yellow-500 border border-yellow-600 rounded-md hover:bg-yellow-600 focus:outline-none focus:border-yellow-700 focus:shadow-outline active:bg-yellow-700">
                {{ __('Disable Two-Factor Authentication') }}
            </button>
        </form>

        @if (session('status') == 'two-factor-authentication-enabled')
        <div class="my-2 text-sm text-gray-500">
            {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
        </div>

        <div>
            {!! auth()->user()->twoFactorQrCodeSvg() !!}
        </div>
        @endif

        <div class="my-2 text-sm text-gray-500">
            {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
        </div>

        <div class="my-4 text-xs text-gray-600">
            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
            <div>{{ $code }}</div>
            @endforeach
        </div>

        <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
            @csrf

            <button type="submit"
                class="flex justify-center px-4 py-2 text-white transition duration-300 ease-in-out bg-green-500 border border-green-600 rounded-md hover:bg-green-600 focus:outline-none focus:border-green-700 focus:shadow-outline active:bg-green-700">
                {{ __('Regenerate Recovery Codes') }}
            </button>
        </form>
        @endif
    </div>
</div>
