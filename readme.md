<p  align="center">
    <img  src="https://github.com/ycore/ycore/blob/gh-pages/resources/svg/fortify-ui.svg" width="400">
</p>

# **FortifyUi**: _[Laravel Fortify][link-fortify]_-powered authentication UI

## Introduction

[**FortifyUi**][link-fortify-ui] combines the robust authentication features of _[Laravel Fortify][link-fortify]_ with an easy-to-setup authentication UI. [**FortifyUi**][link-fortify-ui] includes _[tailwindcss][link-tailwind]_-styled authentication UI blade views as default.
``` bash
$ php artisan fortify-ui:install
```
[**FortifyUi**][link-fortify-ui] also provides entirely 'unstyled' authentication UI views with minimal markup.
``` bash
$ php artisan fortify-ui:install ycore:fortify-ui-unstyled:unstyled
```
[**FortifyUi**][link-fortify-ui] further makes it easy to install custom-contributed authentication UI views.
``` bash
$ php artisan fortify-ui:install my-vendor:my-package
  or
$ php artisan fortify-ui:install my-vendor:my-package:bootstrap
```

[![Latest Version on Packagist][ico-version]][link-packagist]

### Why does FortifyUi exist?

- _[Laravel UI](https://github.com/laravel/ui)_ has been the de-facto simple Laravel authentication UI scaffold for many development projects. It does however not include many of the features provided by _[Laravel Fortify][link-fortify]_.
- _[Laravel Fortify][link-fortify]_ provides a robust authentication backend for Laravel but requires that developers build the UI stack.
- _[Laravel Jetstream](https://github.com/laravel/jetstream)_ includes robust login, registration, email verification _(powered by Fortify)_, API support _(Laravel Sanctum)_ etc., and uses `tailwindcss` with either `Livewire` or `Inertia` scaffolding. Jetstream is however primarily designed for use with new projects and the additional scaffolding may not be perfect and pragmatic for many projects.

[**FortifyUi**][link-fortify-ui] builds on the recommendations outlined in the _[Laravel Fortify documentation](https://github.com/laravel/fortify#official-documentation)_. It provides a quick and simple authentication scaffold for new Laravel projects. It can also ease the upgrade path for existing projects wishing to move from _[Laravel UI](https://github.com/laravel/ui)_ to the _[Laravel Fortify][link-fortify]_ authentication provider.

## Installation
_(requires Laravel 8.0+) - see _[Upgrading Laravel](https://laravel.com/docs/master/upgrade)_ if necesarry_

``` bash
$ composer require ycore/fortify-ui
```
This package utilises package auto-discovery. There is no need to add the service providers manually. You may notice the following message post-autoload.

`Discovered Package: ycore/fortify-ui`

---
<p align="center">
    <img  src="https://github.com/ycore/ycore/blob/gh-pages/resources/gif/fortify-ui-cli.gif" width="720">
</p>

---
## Usage

### Install with default `tailwindcss` views
The [**FortifyUi**][link-fortify-ui] default option installs authentication blade views styled with _[tailwindcss][link-tailwind]_.

``` bash
$ php artisan fortify-ui:install
```

### Install _[tailwindcss][link-tailwindnpm]_ via npm

:hourglass_flowing_sand:&nbsp; Install npm and initialize tailwind
```bash
$ npm install tailwindcss --save-dev
$ npx tailwindcss init
```

:hourglass_flowing_sand:&nbsp; Add the _[tailwindcss][link-tailwind]_ directives into `resources/css/app.css`.

```css
@import "tailwindcss/base";
@import "tailwindcss/components";
@import "tailwindcss/utilities";
```
:hourglass_flowing_sand:&nbsp; Require _[tailwindcss][link-tailwind]_ in `webpack.config.js`.
```javascript
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'), // <- add this line to the mix webpack config
    ]);
```

:hourglass_flowing_sand:&nbsp; Build the assets
```bash
$ npm run dev
```
:hourglass:&nbsp; Confirm the routes are available
```bash
$ php artisan route:list
```

**Done** &nbsp;:white_check_mark:

:point_up: _These tailwind installation instructions presupposes that you are using `tailwindcss >= v1.9` and `Laravel >= v8.0` with the postcss webpack configuration and have installed laravel mix using `npm install laravel-mix --save-dev`_.

:information_source:&nbsp; For additional instructions on installing and configuring tailwindcss including using _[Tailwindcss][link-tailwind]_ from a CDN, or alternative bundlers, see the [Tailwindcss npm][link-tailwindnpm] and [Laravel mix](https://laravel.com/docs/master/mix) documentation.

### Installed Location

Fortify-Ui installs configuration and views at:
```bash
    config
        - fortify.php
    resources
        - views
            - auth/*
            - profile/*
```

## Installation options

[**FortifyUi**][link-fortify-ui] installs a sensible default configuration based on the _[Laravel Fortify][link-fortify]_ recommendations. In addition to `login` and `logout`, the `registration` and `reset-passwords` features are enabled by default. If these defaults are sufficient, there is no need for additional configuration.

### Re-installing with different options
The [**FortifyUi**][link-fortify-ui] install can be re-run. If the `../views/auth` folder of `config` files exist, use the `--force` option to overwrite. Any existing files will be overwritten.

``` bash
$ php artisan fortify-ui:install --force
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
Features can be enabled or disabled by manually editing the `config/fortify.php` file post-install, or by using the `--enable` option during install.

``` bash
$ php artisan fortify-ui:install --enable=[install option]
```
Install Option | Laravel Fortify Feature
-------------- | -----------------------
all | Enables all Features
none | Disables all Features
register | Enables Features::registration()
reset | Enables Features::resetPasswords()
verify | Enables Features::emailVerification()
profile | Enables Features::updateProfileInformation()
two-factor | Enables Features::twoFactorAuthentication()
confirm | Enables Features::registration('confirmPassword' => true)

:information_source:&nbsp; _Show these options using:_
``` bash
$ php artisan fortify-ui:install --help
```
See the _[notes section](a-note-on-enabling-two-factor-authentication)_ for updating the user Model when Two factor authentication is enabled.

## Installing other authentication UI views and scaffolding
It is possible to install your own or community-contributed authentication UI views and scaffolding using the [**FortifyUi**][link-fortify-ui] installer. When installing UI scaffolding from a different package, it can be added as a --dev dependency.

This section explains how to create and/or publish your own or community-maintained authentication UI views and scaffolding.

#### Installing the [**FortifyUi**][link-fortify-ui] `un-styled` UI scaffolding:
Fortify-Ui provides a UI views scaffolding package with no styling and minimal markup. This can either be installed as an un-styled starter into an existing Laravel project or forked to create your own package for styling and scaffolding.
``` bash
$ composer require-dev ycore/fortify-ui-unstyled
$ php artisan fortify-ui:install ycore:fortify-ui-unstyled:unstyled
```

See the _[notes section](creating-the-fortify-ui-unstyled-views)_ for details on how the un-styled views were made.

#### Installing your own or community-provided UI scaffolding:

``` bash
$ composer require-dev vendor-name/package
```
If the `stubs/theme` folder is the same as the `package` name, use:
``` bash
$ php artisan fortify-ui:install vendor-name:package
```
If the `stubs/theme` folder differs from `package` name, or the package contains multiple themes, use:
``` bash
$ php artisan fortify-ui:install vendor-name:package:theme
```

### The default structure of an authentication UI scaffold

When using `fortify-ui:install vendor-name:package:theme`, the [**FortifyUi**][link-fortify-ui] installer will copy views from `../vendor/vendor-name/package/stubs/theme/*` to `../resources/views/`. If you wish to maintain view locations for the default location configuration, views for your custom package should be placed in the following structure.

```bash
vendor-name/
    - package/
        - theme/
            - auth/
                login
                register
                verify-email
                - password/
                    confirm-password
                    forgot-password
                    reset-password
                    two-factor-challenge
        - alternate-theme/
        - another-theme/
```
See the _[FortifyUi un-styled][link-fortify-ui-unstyled]_ scaffold for a reference or fork it to build your own.

## Additional Configuration

[**FortifyUi**][link-fortify-ui] provides some granular configuration options to customize features, locations and behaviour. _The `fortify-ui:publish` artisan command essentially wraps some `vendor:publish --tag` behaviours_ to simplify publishing configuration overrides.

To see the publish options, use the `php artisan fortify:publish --help` command.

### Publishing _[Laravel Fortify][link-fortify]_ configuration
```bash
$ php artisan fortify:publish --config
```
Overwrites the `config/fortify.php` published during installation with the default configuration provided by _[Laravel Fortify][link-fortify]_. See [Enabling Features](enabling-features) or the _[Laravel Fortify documentation](https://github.com/laravel/fortify#official-documentation)_ for additional configuration options.

### Two factor authentication
The _[Laravel Fortify][link-fortify]_ Two Factor Authentication feature requires additional fields in the database and the inclusion of a trait in the User Model.
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
    use TwoFactorAuthenticatable;
```

### Publishing the [**FortifyUi**][link-fortify-ui] configuration
```bash
$ php artisan fortify:publish --ui-config
```
Publishes `config/fortify-ui.php`. It contains the view location configuration. You can use the `views` section to customize view locations.

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

### Publishing the [**FortifyUi**][link-fortify-ui] service provider
```bash
$ php artisan fortify:publish --provider
```

Publishes the `app/Providers/FortifyUiServiceProvider` file and registers it within the `providers` array of your `app` configuration file. Publishing the Service provider facilitates changing many of the actions and view locations for the respective enabled Fortify features.

### Publishing everything
```bash
$ php artisan fortify:publish --all
```

Publishes all the configuration and provider options for both [**FortifyUi**][link-fortify-ui] and _[Laravel Fortify][link-fortify]_.

## Notes

### _[Tailwindcss][link-tailwind]_ version 2.*
The _[tailwindcss][link-tailwind]_ version 2 default color palette is much improved over the version 1 palette. The styling for the default [**FortifyUi**][link-fortify-ui] tailwind-styled views include `bg-gray-50` class to add a subtle, but important nuance to some of the authentication UI views. The views appear correctly on both v1.9.0 and v2.0.0-alpha.5. Should you wish to include the subtle improvement prior to the official release of Tailwind v2, you can include the following `<style>` section.
```css
.bg-gray-50 {
  --bg-opacity: 1;
  background-color: rgba(250, 250, 250, var(--bg-opacity));
}
```
Once _[Tailwindcss][link-tailwind]_ version 2.* is released, this package will be updated to support the latest official version.

### Creating the `fortify-ui-unstyled` views.

The `fortify-ui-unstyled` views were created by cloning the `stubs` folder from the main [**FortifyUi**][link-fortify-ui] package, then regexp-stripping the `class=""` attributes from all html tags in a vscode editor.
```bash
search: [\n| ]*class="[^"]*?"
```

### Installing from alternate repositories
#### Install from a git repository directly
Add a `repositories` section for the git repository to the project `composer.json`:

``` json
"repositories": [
    { "type": "vcs", "url": "https://github.com/vendor-name/package" }
],
```
#### Install from a local symlinked local folder

Add a `repositories` section for the local folder to the project `composer.json`:

``` json
"repositories": [
    { "type": "path", "url": "../vendor-name/package", "symlink": true }
],
```
#### Add `:dev-[branch]` suffix to the package name
Use `composer require-dev vendor-name/package` with a `:dev-` and github `branch` suffix to install a package from an alternate repository.
``` bash
$ composer require-dev vendor-name/package:dev-master
```

## Questions?
### Is this a replacement for Laravel Jetstream?
While both [**FortifyUi**][link-fortify-ui] and Laravel Jetstream utilizes _[Laravel Fortify][link-fortify]_, Jetstream provides both substantial additional functionality and additional scaffolding options, including _Laravel Livewire_ and _Intertia_, which [**FortifyUi**][link-fortify-ui] does not aim to replicate or replace. [**FortifyUi**][link-fortify-ui] does however follow the basic recommendations from the _[Laravel Fortify documentation](https://github.com/laravel/fortify#official-documentation)_ for implementing an authentication UI scaffold.
### Can it be used to replace Laravel UI?
The Laravel UI authentication package has been through many iterations and has often been tightly integrated. It would be practically impossible to provide anything approaching a comprehensive answer that covers all scenarios. [**FortifyUi**][link-fortify-ui] was however created and have been used to migrate some of our internal and client projects from a Laravel UI-based authentication implementation to _[Laravel Fortify][link-fortify]_. Many of the granular installation options exist because we required them while migrating.
### What are the other options?
It is possible to follow the relatively straightforward _[Laravel Fortify documentation](https://github.com/laravel/fortify#official-documentation)_ to implement your own authentication UI scaffold - like we did.

[Zack Warren](https://github.com/zacksmash/fortify-ui) published a package with largely similar functionality and somewhat different design. We may possibly have used that ourselves had we discovered it earlier.

If you are aware of more alternatives, or you create a custom UI scaffolding package that utilizes [**FortifyUi**][link-fortify-ui], please let us know.

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
[link-fortify-ui-unstyled]: https://github.com/ycore/fortify-ui-unstyled
[link-fortify]: https://packagist.org/packages/laravel/fortify
[link-tailwind]: https://www.tailwindcss.com
[link-tailwindnpm]: https://tailwindcss.com/docs/installation#process-your-css-with-tailwind

[link-packagist]: https://packagist.org/packages/ycore/fortify-ui
[link-author]: https://github.com/ycore
[link-contributors]: ../../contributors
