<x-layouts.guest>
    <x-alerts.errors />
    <x-alerts.status />
    <div class="fixed top-0 right-0 flex items-center justify-end px-4 py-2 space-x-4">
        <div class="text-gray-800">
            {{ auth()->user()->name }}
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-gray-700 uppercase hover:underline hover:text-blue-700">
                {{ __('Logout') }}
            </button>

        </form>
    </div>
    {{-- EXAMPLE: this section contains forms and routes not readily accesible upon intital installation. It is meant to be repalced --}}
    <section class="flex flex-col px-4 pt-12 mx-auto">
        <div class="py-2">
            <p class="text-yellow-400">EXAMPLE: This section includes examples of the forms that can be implemented for each of the selected features</p>
        </div>
        @php
            $views['update-profile-information'] = config('fortify-ui.views.update-profile-information');
            $views['update-password'] = config('fortify-ui.views.update-password');
            $views['two-factor-authentication'] = config('fortify-ui.views.two-factor-authentication');
        @endphp
        <div class="flex flex-wrap justify-between mx-auto space-x-8">
            <div class="space-y-4">
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
                    <div>
                        @include($views['update-profile-information'])
                    </div>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div>
                        @include($views['update-password'])
                    </div>
                @endif
            </div>
            <div class="space-y-4">
                @if (Route::has('password.confirm'))
                <div>
                    <a href="{{ route('password.confirm') }}"
                        class="text-blue-600 transition duration-150 ease-in-out hover:text-blue-400 focus:outline-none focus:underline">
                        {{ __('Confirm your password?') }}
                    </a>
                </div>
                @endif
                @if (Route::has('password.confirmation'))
                <div>
                    <a href="{{ route('password.confirmation') }}"
                        class="text-blue-600 transition duration-150 ease-in-out hover:text-blue-400 focus:outline-none focus:underline">
                        {{ __('Password confirmation status') }}
                    </a>
                </div>
                @endif
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()))
                <div>
                    <a href="{{ route('verification.notice') }}"
                        class="text-blue-600 transition duration-150 ease-in-out hover:text-blue-400 focus:outline-none focus:underline">
                        {{ __('Email verification') }}
                    </a>
                </div>
                @endif
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                    @if (auth()->user()->two_factor_recovery_codes)
                    <div>
                        <a href="{{ url('/user/two-factor-qr-code') }}"
                            class="text-blue-600 transition duration-150 ease-in-out hover:text-blue-400 focus:outline-none focus:underline">
                            {{ __('Two factor QR code') }}
                        </a>
                    </div>
                    <div>
                        <a href="{{ url('/user/two-factor-recovery-codes') }}"
                            class="text-blue-600 transition duration-150 ease-in-out hover:text-blue-400 focus:outline-none focus:underline">
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
