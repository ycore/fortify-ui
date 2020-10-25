# **FortifyUI**: _[Laravel Fortify][link-fortify]_-powered authentication UI

## Introduction
[**FortifyUI**][link-fortify-ui] combines the robust authentication features of the _[Laravel Fortify][link-fortify]_ headless authentication backend with easy-to-install authentication UI.

[**FortifyUI**][link-fortify-ui] builds on the recommendations outlined in the _[Laravel Fortify documentation](https://github.com/laravel/fortify#official-documentation)_. It provides a simple and comprehensive authentication scaffold. It can also ease the upgrade path for existing projects wishing to move from _[Laravel UI](https://github.com/laravel/ui)_ to the _[Laravel Fortify][link-fortify]_ authentication provider.

<div align="center">
    <img src="https://github.com/ycore/fortify-ui/blob/master/stubs/svg/fortify-ui.svg" width="400">
</div>

## Requirements
[**FortifyUI**][link-fortify-ui] requires Laravel 8.0+. See _[Upgrading Laravel](https://laravel.com/docs/master/upgrade)_ if necesarry

[![Latest Version on Packagist][ico-version]][link-packagist]

## Installation

[**FortifyUI**][link-fortify-ui] provisions the actions and configuration for _[Laravel Fortify][link-fortify]_.

The authentication views and scaffolding are implemented using **FortifyUI**-designed or community-contributed packages. Installing an authentication views package, also installs [**FortifyUI**][link-fortify-ui].

- <img  src="https://github.com/ycore/fortify-ui/blob/master/stubs/svg/fortify-login.svg" width="50"> Follow the __Fortify-tailwind__ [installation instructions][link-fortify-tailwind] to install a _[Tailwind CSS](tailwindcss.com)_-styled authentication UI
- <img  src="https://github.com/ycore/fortify-ui/blob/master/stubs/svg/fortify-login.svg" width="50"> Follow the __Fortify-unstyled__ [installation instructions][link-fortify-unstyled] to install a completely _un-styled_ authentication UI

You can also design your own authentication UI for your frontend library or framework of choice. The [Fortify-unstyled][link-fortify-unstyled] package would be an ideal starter to fork.

_If you design an authentication front-end for [**FortifyUI**][link-fortify-ui] that the community could benefit from, please let us know, and we'd be happy to include reference to it here._

## Post-install configuration options

The post-installation configuration options are available once you have installed an authentication UI views package.

The authentication UI packages install a sensible default configuration based on the _[Laravel Fortify][link-fortify]_ recommendations. The `login`, `logout`, `registration` and `reset-passwords` features and routes are enabled by default. If these defaults are sufficient, there is no need for additional configuration.

 [**FortifyUI**][link-fortify-ui] provides some granular configuration options to customize features, locations and behaviour. _The `fortify-ui:publish` artisan command essentially wraps some `vendor:publish --tag` behaviours_ to simplify publishing configuration overrides.

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
Features can be enabled or disabled by manually editing the `config/fortify.php` file post-install, or by using the `fortify-ui:publish --enable` option.

This example enables the registration, reset-passwords and email-verification features.

``` bash
$ php artisan fortify-ui:publish --enable=register,reset,verify
```
Install Option | Laravel Fortify Feature
-------------- | -----------------------
all | Enables all additional Features
none | Disables all additional Features
register | Enables Features::registration()
reset | Enables Features::resetPasswords()
verify | Enables Features::emailVerification()
profile | Enables Features::updateProfileInformation()
two-factor | Enables Features::twoFactorAuthentication()
confirm | Enables Features::registration('confirmPassword' => true)

See _[Two factor authentication](#a-note-on-enabling-two-factor-authentication)_ for notes on updating the User model when two factor authentication is enabled.

### Two factor authentication
The two factor authentication feature can be enabled by manually editing the `config/fortify.php` file, or by using the `--enable` option. The FortifyUIServiceProvider registers the view automatically once the feature is enabled in the config file.

Two factor authentication requires additional fields in the database and the inclusion of a trait in the User Model.
#### Publishing _[Laravel Fortify][link-fortify]_ migrations
```bash
$ php artisan fortify:publish --migrations
$ php artisan migrate
```
#### Adding the TwoFactorAuthenticatable trait
Add the `TwoFactorAuthenticatable` trait to `app/Models/User.php`

```php
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;
    ...
```
### Publishing the _[Laravel Fortify][link-fortify]_ configuration
```bash
$ php artisan fortify:publish --config
```
Overwrites the `config/fortify.php` published during installation with the default configuration provided by _[Laravel Fortify][link-fortify]_. See [Enabling Features](#enabling-features) or the _[Laravel Fortify documentation](https://github.com/laravel/fortify#official-documentation)_ for additional configuration options.


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

### The kitchen sink
```bash
$ php artisan fortify:publish --all
```

Publishes all the configuration and provider options for both [**FortifyUI**][link-fortify-ui] and _[Laravel Fortify][link-fortify]_.

## Notes

## Questions?

### Is this a replacement for Laravel Jetstream?
While both [**FortifyUI**][link-fortify-ui] and Laravel Jetstream utilizes _[Laravel Fortify][link-fortify]_, Jetstream provides both substantial additional functionality and additional scaffolding options, including _Laravel Livewire_ and _Intertia_, which [**FortifyUI**][link-fortify-ui] does not aim to replicate or replace. [**FortifyUI**][link-fortify-ui] does however follow the basic recommendations from the _[Laravel Fortify documentation](https://github.com/laravel/fortify#official-documentation)_ for implementing an authentication UI scaffold without much of the additional scaffolding.
### Can it be used to replace Laravel UI?
_[Laravel UI](https://github.com/laravel/ui)_ has been the de-facto simple Laravel authentication UI scaffold for many development projects. It does however not include many of the features provided by _[Laravel Fortify][link-fortify]_. _[Laravel UI](https://github.com/laravel/ui)_ has been through many iterations and has often been tightly integrated. It would be practically impossible to provide anything approaching a comprehensive answer that covers all scenarios. [**FortifyUI**][link-fortify-ui] was however created and have been used to migrate some of our internal and client projects from a Laravel UI-based authentication implementation to _[Laravel Fortify][link-fortify]_. Many of the granular configuration options exist because we required them while migrating.
### What are the other options?
It is possible to follow the relatively straightforward _[Laravel Fortify documentation](https://github.com/laravel/fortify#official-documentation)_ to implement your own authentication UI scaffold - like we did.

[Zack Warren](https://github.com/zacksmash/fortify-ui) published a package with largely similar functionality and somewhat different design. We may possibly have used that ourselves had we discovered it earlier.

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

[ico-version]: https://img.shields.io/packagist/v/ycore/fortify-ui.svg?style=flat-square

[link-fortify-ui]: https://packagist.org/packages/ycore/fortify-ui
[link-fortify-unstyled]: https://github.com/ycore/fortify-unstyled#installation
[link-fortify-tailwind]: https://github.com/ycore/fortify-tailwind#installation

[link-fortify]: https://packagist.org/packages/laravel/fortify

[link-packagist]: https://packagist.org/packages/ycore/fortify-ui
[link-author]: https://github.com/ycore
[link-contributors]: ../../contributors
