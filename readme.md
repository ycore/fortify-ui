# **FortifyUI**: _[Laravel Fortify][link-fortify]_-powered authentication UI

## Introduction
[**FortifyUI**][link-fortify-ui] connects the robust authentication features of the _[Laravel Fortify][link-fortify]_ headless authentication backend with easy-to-install authentication UI.

It provides a simple and comprehensive authentication scaffold. It can also ease the upgrade path for existing projects wishing to move from _[Laravel UI](https://github.com/laravel/ui)_ to the _[Laravel Fortify][link-fortify]_ authentication provider.

<div align="center">
    <img src="https://github.com/ycore/fortify-ui/blob/master/stubs/svg/fortify-ui.svg" width="50%" >
</div>

## Requirements
[**FortifyUI**][link-fortify-ui] requires Laravel 8.0+. See _[Upgrading Laravel](https://laravel.com/docs/master/upgrade)_ if necesarry

[![Latest Version on Packagist][ico-version]][link-packagist]

## Installation

[**FortifyUI**][link-fortify-ui] provides a headless implementation of the Laravel Fortify authentication backend, following the recommendations outlined in the _[Laravel Fortify documentation](https://laravel.com/docs/fortify)_.

Authentication views and scaffolding are implemented using **FortifyUI**-designed or community-contributed frontend packages. [**FortifyUI**][link-fortify-ui] doesn't need to be installed seperately. Installing an authentication frontend package, also installs [**FortifyUI**][link-fortify-ui].

Select a **FortifyUI** authentication frontend to install|
-------------- |
<img src="https://github.com/ycore/fortify-tailwind/blob/master/stubs/tailwind/resources/svg/fortify-icon.svg" width="50"> Follow the [Fortify-tailwind installation instructions][link-fortify-tailwind] to install the _tailwindcss-styled_ authentication UI |
<img src="https://github.com/ycore/fortify-unstyled/blob/master/stubs/unstyled/resources/svg/fortify-icon.svg" width="50"> Follow the [Fortify-unstyled installation instructions][link-fortify-unstyled] to install a completely _un-styled_ authentication UI |

You can design your own authentication UI for your frontend library or framework of choice. The <img src="https://github.com/ycore/fortify-unstyled/blob/master/stubs/unstyled/resources/svg/fortify-icon.svg" width="50"> [Fortify-unstyled][link-fortify-unstyled] package would be an ideal front-end starter to fork.

_If you design an authentication front-end for [**FortifyUI**][link-fortify-ui] that the community could benefit from, please let us know, and we'd be happy to include reference to it here._

## Post-install configuration options

The post-installation configuration options become available once you've installed an authentication frontend package.

The default installation provides sensible configuration defaults. The `login`, `logout`, `registration` and `reset-passwords` features and routes are enabled by default. If these defaults are sufficient, there is no need for additional configuration.

 [**FortifyUI**][link-fortify-ui] provides some granular configuration options to customize features, locations and behaviour. _The `fortify-ui:publish` artisan command essentially combines multiple `vendor:publish --tag` behaviours and conflict-checking_ to simplify publishing configuration overrides.

:information_source:&nbsp; Show the post-installation configuration options using:

``` bash
$ php artisan fortify-ui:publish --help
```

### Enabling features
The following features are enabled in `config/fortify.php` using the default installation.
```php
    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        //Features::emailVerification(),
        //Features::updateProfileInformation(),
        //Features::twoFactorAuthentication(),
        //Features::twoFactorAuthentication([
            //'confirmPassword' => true,
        //]),
        //Features::updatePasswords(),
    ],
```
Features can be enabled or disabled editing the `config/fortify.php` file post-install. See _[Fortify Features](https://laravel.com/docs/fortify#fortify-features)_ for additional configuration options.

See _[Two factor authentication](#a-note-on-enabling-two-factor-authentication)_ on the additional requirements when two factor authentication is enabled.

### Two factor authentication
The two factor authentication feature can be enabled in `config/fortify.php`. The FortifyUIServiceProvider registers the view automatically once the feature is enabled in the config file.

Two factor authentication requires migration of additional fields to the database and additions to the User Model.
#### Publishing Fortify migrations
```bash
$ php artisan fortify:publish --migrations
$ php artisan migrate
```
#### Adding the TwoFactorAuthenticatable trait
Add the `TwoFactorAuthenticatable` trait and hidden fields to `app/Models/User.php`

```php
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;
    ...

    protected $hidden = [
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
    ...
```

### Publishing the _[Laravel Fortify][link-fortify]_ configuration
```bash
$ php artisan fortify:publish --config
```
Overwrites the `config/fortify.php` published during the intial installation with the default configuration provided by _[Laravel Fortify][link-fortify]_. See the _[Laravel Fortify documentation](https://laravel.com/docs/fortify)_ for additional configuration options.

### Publishing the [**FortifyUI**][link-fortify-ui] configuration
Publishing `config/fortify-ui.php` allows customising the view locations.
```bash
$ php artisan fortify:publish --ui-config
```
The `views` section can be used to customize view locations.

```php
'views' => [
    'login' => 'auth.login',
    'register' => 'auth.register',
    'verify-email' => 'auth.verify-email',
    'reset-password' => 'auth.password.reset-password',
    'forgot-password' => 'auth.password.forgot-password',
    'confirm-password' => 'auth.password.confirm-password',
    'two-factor-challenge' => 'auth.password.two-factor-challenge',
    'update-password' => 'profile.update-password',
    'two-factor-authentication' => 'profile.two-factor-authentication',
    'update-profile-information' => 'profile.update-profile-information',
],
```

### Publishing the [**FortifyUI**][link-fortify-ui] service provider
Publishing the FortifyUIServiceProvider allows customising many of the actions and view locations for enabled Fortify features.
```bash
$ php artisan fortify:publish --provider
```

Publishes the `app/Providers/FortifyUIServiceProvider` file and registers it within the `providers` array of your `app` configuration file.

```php
...
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

...
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
...
```

### The kitchen sink
```bash
$ php artisan fortify:publish --all
```

Publishes all the configuration and provider options for both [**FortifyUI**][link-fortify-ui] and _[Laravel Fortify][link-fortify]_.

## Questions?

### Is this a replacement for Laravel Jetstream?
While both [**FortifyUI**][link-fortify-ui] and Laravel Jetstream utilizes _[Laravel Fortify][link-fortify]_, Jetstream provides both substantial additional functionality and additional scaffolding options, including _Laravel Livewire_ and _Intertia_, which [**FortifyUI**][link-fortify-ui] does not aim to replicate or replace. [**FortifyUI**][link-fortify-ui] does however follow the basic recommendations from the _[Laravel Fortify documentation](https://laravel.com/docs/fortify)_ for implementing an authentication UI scaffold without much of the additional scaffolding.
### Can it be used to replace Laravel UI?
_[Laravel UI](https://github.com/laravel/ui)_ has been the de-facto simple Laravel authentication UI scaffold for many development projects, but doesn't include many of the _[Laravel Fortify][link-fortify]_ features. _[Laravel UI](https://github.com/laravel/ui)_ has been through many iterations and has often been tightly integrated. It would be diffcult to comprehensive predict all upgrade scenarios.

[**FortifyUI**][link-fortify-ui] was however created and have been used to migrate some of our internal and client projects from _[Laravel UI](https://github.com/laravel/ui)_ to a _[Laravel Fortify][link-fortify]_-based authentication implementation. Many of the granular configuration options exist because we needed them for both new installations and while migrating.
### What are the other options?
It is possible to follow the relatively straightforward _[Laravel Fortify documentation](https://laravel.com/docs/fortify)_ to implement your own authentication UI scaffold - like we did.

[Zack Warren](https://github.com/zacksmash/fortify-ui) published a package with largely similar functionality and a somewhat different design. We may possibly have used that ourselves had we discovered it earlier.

If you are aware of more alternatives, or you create a custom UI scaffolding package that utilizes [**FortifyUI**][link-fortify-ui], please let us know.

## Changelog

Please see the [Changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [Contributing](contributing.md) for details.

## Security

Should you discover any security-related issues, please email y-core@outlook.com instead of using the issue tracker.

## Credits

- [Johan Meyer][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [License file](license.md) for more information.

[link-fortify-ui]: https://packagist.org/packages/ycore/fortify-ui
[link-fortify-unstyled]: https://github.com/ycore/fortify-unstyled#installation
[link-fortify-tailwind]: https://github.com/ycore/fortify-tailwind#installation

[link-fortify]: https://packagist.org/packages/laravel/fortify

[ico-version]: https://img.shields.io/packagist/v/ycore/fortify-ui.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/ycore/fortify-ui
[link-author]: https://github.com/ycore
[link-contributors]: ../../contributors
