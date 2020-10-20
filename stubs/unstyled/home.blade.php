<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />
    <div>
        <div>
            {{ auth()->user()->name }}
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit">
                {{ __('Logout') }}
            </button>

        </form>
    </div>
    {{-- EXAMPLE: this section contains forms and routes not readily accesible upon intital installation. It is meant to be repalced --}}
    <section>
        <div>
            <p>EXAMPLE: This section includes examples of the forms that can be implemented for each of the selected features</p>
        </div>
        @php
            $views['update-profile-information'] = config('fortify-ui.views.update-profile-information');
            $views['update-password'] = config('fortify-ui.views.update-password');
            $views['two-factor-authentication'] = config('fortify-ui.views.two-factor-authentication');
        @endphp
        <div>
            <div>
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
                    <div>
                        @include ($views['update-profile-information'])
                    </div>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div>
                        @include($views['update-password'])
                    </div>
                @endif
            </div>
            <div>
                @if (Route::has('password.confirm'))
                <div>
                    <a href="{{ route('password.confirm') }}">
                        {{ __('Confirm your password?') }}
                    </a>
                </div>
                @endif
                @if (Route::has('password.confirmation'))
                <div>
                    <a href="{{ route('password.confirmation') }}">
                        {{ __('Password confirmation status') }}
                    </a>
                </div>
                @endif
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()))
                <div>
                    <a href="{{ route('verification.notice') }}">
                        {{ __('Email verification') }}
                    </a>
                </div>
                @endif
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                    @if(auth()->user()->two_factor_recovery_codes)
                    <div>
                        <a href="{{ url('/user/two-factor-qr-code') }}">
                            {{ __('Two factor QR code') }}
                        </a>
                    </div>
                    <div>
                        <a href="{{ url('/user/two-factor-recovery-codes') }}">
                            {{ __('Two factor recovery codes') }}
                        </a>
                    </div>
                    @endif
                    <div>
                        @include($views['two-factor-authentication'])
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.guest>
