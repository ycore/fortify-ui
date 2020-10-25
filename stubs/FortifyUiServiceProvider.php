<?php

namespace Ycore\FortifyUI;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Ycore\FortifyUI\Actions\CreateNewUser;
use Ycore\FortifyUI\Actions\ResetUserPassword;
use Ycore\FortifyUI\Actions\UpdateUserPassword;
use Ycore\FortifyUI\Actions\UpdateUserProfileInformation;
use Ycore\FortifyUI\Commands\FortifyUIPublish;

class FortifyUIServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::loginView(function () {
            return view(config('fortify-ui.views.login'));
        });

        Fortify::confirmPasswordView(function () {
            return view(config('fortify-ui.views.confirm-password'));
        });

        $this->bootFeatures();

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/fortify-ui.php', 'fortify-ui');
    }

    /**
     * Boot enabled featured.
     *
     * @return void
     */
    protected function bootFeatures(): void
    {
        if (Features::enabled(Features::resetPasswords())) {
            Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

            Fortify::requestPasswordResetLinkView(function () {
                return view(config('fortify-ui.views.forgot-password'));
            });

            Fortify::resetPasswordView(function ($request) {
                return view(config('fortify-ui.views.reset-password'), ['request' => $request]);
            });
        }

        if (Features::enabled(Features::registration())) {
            Fortify::registerView(function () {
                return view(config('fortify-ui.views.register'));
            });
        }

        if (Features::enabled(Features::emailVerification())) {
            Fortify::verifyEmailView(function () {
                return view(config('fortify-ui.views.verify-email'));
            });
        }

        if (Features::enabled(Features::updateProfileInformation())) {
            Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        }

        if (Features::enabled(Features::updatePasswords())) {
            Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        }

        if (Features::enabled(Features::twoFactorAuthentication())) {
            Fortify::twoFactorChallengeView(function () {
                return view(config('fortify-ui.views.two-factor-challenge'));
            });
        }
    }

}
