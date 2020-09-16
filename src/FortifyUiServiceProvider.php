<?php

namespace Ycore\FortifyUi;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Ycore\FortifyUi\Actions\CreateNewUser;
use Ycore\FortifyUi\Actions\ResetUserPassword;
use Ycore\FortifyUi\Actions\UpdateUserPassword;
use Ycore\FortifyUi\Actions\UpdateUserProfileInformation;
use Ycore\FortifyUi\Commands\FortifyUiInstall;
use Ycore\FortifyUi\Commands\FortifyUiPublish;

class FortifyUiServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->configurePublishing();
        }
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
     * Boot Console services.
     *
     * @return void
     */
    protected function configurePublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/fortify-ui.php' => config_path('fortify-ui.php'),
            ], 'fortify-ui-config');

            $this->publishes([
                __DIR__ . '/../stubs/FortifyUiServiceProvider.php' => app_path('Providers/FortifyUiServiceProvider.php'),
            ], 'fortify-provider');
        }

        $this->commands([
            FortifyUiInstall::class,
            FortifyUiPublish::class,
        ]);
    }
}
