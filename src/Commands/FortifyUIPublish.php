<?php

namespace Ycore\FortifyUI\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;

class FortifyUIPublish extends Command
{
    protected $config;

    protected $signature = 'fortify-ui:publish
        {--show-enabled : Shows the currently-enabled Laravel Fortify features}
        {--config : Publishes the Laravel Fortify config file - `config/fortify.php`}
        {--migrations : Publishes the Laravel Fortify migrations for two-factor auth}
        {--ui-config : Publishes the FortifyUI config file - `config/fortify-ui.php`}
        {--provider : Publishes the FortifyUI service provider}
        {--all : The kitchen sink; publishes all Laravel Fortify config, migrations, providers and actions}
        ';

    protected $description = 'Publishes Laravel Fortify and FortifyUI configurations';

    protected $stubs;

    public function __construct(Repository $config)
    {
        $this->config = $config;

        parent::__construct();
    }

    public function handle()
    {
        if ($this->option('show-enabled')) {
            $this->showFortifyFeatures();
            return;
        }

        $this->comment('Publishing configuration options ...');

        $this->publishAssets('Laravel\Fortify\FortifyServiceProvider', ['config', 'migrations']);
        $this->publishAssets('Ycore\FortifyUI\FortifyUIServiceProvider', ['ui-config', 'provider']);

        $this->showFortifyFeatures();

        $this->comment('Published successfully.');
    }

    /**
     * Publishes the nominated assets
     *
     * @param string $provider
     * @param string $tags
     * @return void
     */
    protected function publishAssets($provider, $tags)
    {
        if (! $this->option('all')) {
            foreach ($tags as $tag) {
                if ($this->option($tag)) {
                    $arguments['--tag'][] = 'fortify-' . $tag;
                }
            }
        }

        if ($this->option('all') || isset($arguments)) {
            $arguments['--provider'] = $provider;
            $arguments['--force'] = true;
            $this->call('vendor:publish', $arguments);
            $this->info('- Published options for ' . $provider);
        }

        if ($this->option('all') || $this->option('provider')) {
            $this->insertProvider();
        }

    }

    /**
     * Shows the fortify enabled features
     *
     * @return void
     */
    protected function showFortifyFeatures()
    {
        $this->config->set('fortify', require config_path('fortify.php'));

        $this->comment('The following features are enabled in config/fortify.php:');

        $features = collect(config('fortify.features'))->map(function ($feature) {
            return  ['feature' => $feature];
        })->toArray();

        $this->table(['Fortify features enabled'], $features);

        if (in_array('two-factor-authentication', config('fortify.features'))
            || $this->option('migrations') || $this->option('all')) {
            $this->comment('To publish and load new migrations run:');
            $this->info('  `php artisan fortify:publish -migrations` and');
            $this->info('  `php artisan migrate` and');
            $this->info('   add the `TwoFactorAuthenticatable` trait to the User model');
        }
    }

}
