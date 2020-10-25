<?php

namespace Ycore\FortifyUi\Commands;

use App\Providers\RouteServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class FortifyUiInstall extends Command
{
    protected $signature = 'fortify-ui:install
        {views=tailwind : Installs the FortifyUi views and scaffolding [ vendor:package[:style] ]}
        {--f|force : Overwrite any existing views previously installed or created}
        {--enable=register,reset : Enabled features [ all,none,register,reset,verify,profile,update,two-factor[,confirm] ]}';

    protected $description = 'Install authentication views for FortifyUi';

    protected $stubs;

    protected $configRepository;

    protected $featureMap = [
        'register' => '//Features::registration()',
        'reset' => '//Features::resetPasswords()',
        'verify' => '//Features::emailVerification()',
        'profile' => '//Features::updateProfileInformation()',
        'two-factor' => '//Features::twoFactorAuthentication()',
        'confirm' => "//Features::twoFactorAuthentication([\n            //'confirmPassword' => true,\n        //])",
        'update' => '//Features::updatePasswords()',
    ];

    public function __construct(Repository $repository)
    {
        $this->configRepository = $repository;

        parent::__construct();
    }

    public function handle()
    {
        if (! $this->setStubs()) {
            $this->error('! No view stubs found for ' . $this->argument('views'));
            return;
        }

        if (! $this->clobberInstall()) {
            $this->error('! The resources/views/auth and/or config/fortify*.php exists. Use --force to overwrite.');
            return;
        }

        switch ($this->option('enable')) {
            case 'all':
                $enabled = 'register,reset,verify,profile,update,confirm';
                break;
            case 'none':
                $enabled = '';
                break;
            default:
                $enabled = $this->option('enable');
                break;
        }

        $this->comment('Installing FortifyUi views...');
        $this->publishViewStubs();
        $this->updateEnabledConfig($enabled);
        $this->addHomeRoute();

        $this->comment('Installed FortifyUi views successfully.');
    }

    protected function setStubs()
    {
        if ($offset = mb_strrpos($this->argument('views'), ':')) {
            $package = implode('/', array_slice(explode(':', $this->argument('views')), 0, 2));
            $stub = substr($this->argument('views'), $offset + 1);

            return file_exists($this->stubs = base_path('vendor/' . $package) . '/stubs/' . $stub);
        }

        return file_exists($this->stubs = __DIR__ . '/../../stubs/' . $this->argument('views'));
    }

    protected function clobberInstall()
    {
        return ($this->option('force') ||
            ! (file_exists(base_path('resources/views/auth')) &&
                file_exists(config_path('fortify.php')) &&
                file_exists(config_path('fortify-ui.php')))
            );
    }

    protected function publishViewStubs()
    {
        if (! File::copyDirectory($this->stubs, resource_path('views'))) {
            $this->error('! Error publishing views for ' . $this->argument('views'));
            return;
        }

        $this->info(sprintf('- Published %s views to %s/auth',
            $this->argument('views'),
            str_replace(base_path(), '.', resource_path('views'))
        ));
    }

    protected function updateEnabledConfig($enabled)
    {
        $features = explode(',', $enabled);
        $this->callSilent('fortify-ui:publish', ['--config' => true]);

        $this->updateConfigFile(config_path('fortify.php'), 'features', $this->enabledMap($features));
        $this->reloadConfig();
        $this->call('fortify-ui:publish', ['--show-only' => true]);
    }

    protected function enabledMap($features)
    {
        if (in_array('confirm', $features)) {
            $features = array_diff($features, ['two-factor']);
            unset($this->featureMap['two-factor']);
        }

        $enabled = collect($this->featureMap)->transform(function ($value, $key) use ($features) {
            if (in_array($key, $features)) {
                return str_replace('//', '', $value);
            } else {
                return $value;
            }
        });

        return $this->formatEnabledMap($enabled);
    }

    protected function addHomeRoute()
    {
        if (! Route::has('home')) {
            $home = trim(RouteServiceProvider::HOME, '/');

            file_put_contents(base_path('routes/web.php'), $this->formatHomeRoute($home), FILE_APPEND);

            $this->info('- Appended `home` route to web.php');
        }
    }

    protected function reloadConfig()
    {
        $this->configRepository->set('fortify', require config_path('fortify.php'));
    }

    // walk the config file using word boundaries, replacing the value for
    // a config key between the outer-most brackets, more reliably than recurring regexp
    protected function updateConfigFile($filename, $key, $value, $brackets = '[]')
    {
        $config = File::get($filename);

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

        $config = substr($config, 0, $from + 1) . $value . '    ' . substr($config, $to, strlen($config) + strlen($value));

        File::put($filename, $config);
    }

    protected function formatEnabledMap($enabled)
    {
        $cr = PHP_EOL;
        $features = $enabled->implode(",{$cr}        ");
        $comma = (count($enabled) === 0) ? '' : ',';
        return <<<"EOS"
{$cr}        {$features}{$comma}{$cr}
EOS;
    }

    protected function formatHomeRoute($home)
    {
        return <<<"EOS"
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('{$home}', 'home')->name('home');
});
EOS;
    }
}
