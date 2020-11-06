<?php

namespace Ycore\FortifyUI\Support;

use App\Providers\RouteServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ConfigurationParser
{

    protected $features = [
        'register' => '//Features::registration()',
        'reset' => '//Features::resetPasswords()',
        'verify' => '//Features::emailVerification()',
        'profile' => '//Features::updateProfileInformation()',
        'two-factor' => "//Features::twoFactorAuthentication([\n            //'confirmPassword' => true,\n        //])",
        'update' => '//Features::updatePasswords()',
    ];

    protected $enabled = [
        'all' => ['register', 'reset', 'verify', 'profile', 'update'],
        'none' => [],
    ];

    public function __construct()
    {
        $this->configRepository = new Repository;
    }

    /**
     * Appends the home route to routes/web.php
     *
     * @return void
     */
    public function appendHomeRoute()
    {
        if (! Route::has('home')) {
            $home = trim(RouteServiceProvider::HOME, '/');

            file_put_contents(base_path('routes/web.php'), $this->formatHomeRoute($home), FILE_APPEND);
        }
    }

    /**
     * Update the fortify config file with enabled features
     *
     * @param array $enabled
     * @return void
     */
    public function updateEnabled($enabled)
    {
        if (! array_diff_key(array_flip($enabled), array_flip(array_keys($this->enabled)))) {
            $enabled = $this->enabled[$enabled[0]];
        }

        $this->updateConfigFile(config_path('fortify.php'), 'features', $this->parseEnabledFeatures($enabled));
    }

    /**
     * Inserts the provider into app.pph if it doesn't exist
     *
     * @return void
     */
    public function insertProvider()
    {
        $config = file_get_contents(config_path('app.php'));

        if (! Str::contains($config, 'App\Providers\FortifyUIServiceProvider::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\Providers\RouteServiceProvider::class,',
                'App\Providers\RouteServiceProvider::class,' . PHP_EOL . '        App\Providers\FortifyUIServiceProvider::class,',
                $config
            ));
        }
    }

    /**
     * Determines whether any files published in the $provider for the $tag exists
     *
     * @param string $tag
     * @return void
     */
    public function anyConflicts($provider, $tag)
    {
        foreach (ServiceProvider::pathsToPublish($provider, $tag) as $from => $to) {
            if (file_exists($to)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Uncomments all enabled Features
     *
     * @param array $features
     * @return string
     */
    protected function parseEnabledFeatures($features)
    {
        $enabled = collect($this->features)->transform(function ($value, $key) use ($features) {
            if (in_array($key, $features)) {
                return str_replace('//', '', $value);
            }
            return $value;
        });

        return $this->formatEnabledFeatures($enabled);
    }

    /**
     * Update the configuration file $value for a particular $key
     *
     * @param string $filename
     * @param string $key
     * @param string $value
     * @return bool|int
     */
    protected function updateConfigFile($filename, $key, $value)
    {
        return file_exists($filename) &&
            File::put($filename, $this->parseConfigFile(File::get($filename), $key, $value));
    }

    /**
     * Parses the configuration string using word boundaries, replacing the value of a
     * config key between the outer-most brackets, more reliably than recurring regexp
     *
     * @param string $config
     * @param string $key
     * @param string $value
     * @param string $brackets
     * @return string
     */
    protected function parseConfigFile($config, $key, $value, $brackets = '[]')
    {
        $boundries = array('\n', '\t', ' ', '"', "'");
        $word = "";
        $count = 0;
        $searching = true;

        for ($x = 1; $x < strlen($config); $x++) {
            if ($searching) {
                if (in_array($config[$x], $boundries)) {
                    if ($word === $key) {
                        $searching = false;
                    }
                    $word = "";
                } else {
                    $word .= $config[$x];
                }
            } else {
                if ($config[$x] === $brackets[0]) {
                    $count++;
                    if ($count === 1) {
                        $from = $x;
                    }
                }
                if ($config[$x] === $brackets[1]) {
                    $count--;
                    if ($from > 0 && $count === 0) {
                        $to = $x;
                        break;
                    }
                }
            }
        }

        return substr($config, 0, $from + 1) . $value . '    ' . substr($config, $to, strlen($config) + strlen($value));
    }

    /**
     * Formats all enabled features config
     *
     * @param string $enabled
     * @return string
     */
    protected function formatEnabledFeatures($enabled)
    {
        $cr = PHP_EOL;
        $features = $enabled->implode(",{$cr}        ");
        $comma = (count($enabled) === 0) ? '' : ',';
        return <<<"EOS"
{$cr}        {$features}{$comma}{$cr}
EOS;
    }

    /**
     * Formats a home route
     *
     * @param string $home
     * @return string
     */
    protected function formatHomeRoute($home)
    {
        return <<<"EOS"
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('{$home}', 'home')->name('home');
});
EOS;
    }

}
