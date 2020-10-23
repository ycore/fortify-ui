<?php

namespace Ycore\FortifyUi\Commands;

use App\Providers\RouteServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class FortifyUiInstall extends Command
{
    protected $signature = 'fortify-ui:install
        {views=tailwind : Installs the FortifyUi views and scaffolding [ vendor:package[:style] ]}
        {--f|force : Overwrite any existing views previously created}';

    protected $description = 'Install authentication views for FortifyUi';

    protected $stubs;

    public function handle()
    {
        if (! $this->setStubs()) {
            $this->error('! No view stubs found for ' . $this->argument('views'));
            return;
        }

        if (! $this->clobberViews()) {
            $this->error('! Views folder resources/views/auth exists. Use --force to overwrite.');
            return;
        }

        $this->comment('Installing FortifyUi views...');
        $this->publishViewStubs();
        $this->addHomeRoute();
        $this->call('fortify-ui:publish', ['--show-only']);

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

    protected function clobberViews()
    {
        return ! file_exists(base_path('resources/views/auth')) || in_array(['force'], $this->options());
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

    protected function addHomeRoute()
    {
        if (! Route::has('home')) {
            $home = trim(RouteServiceProvider::HOME, '/');

            file_put_contents(base_path('routes/web.php'),
                "Route::middleware(['auth', 'verified'])->group(function () {
                    Route::view('{$home}', 'home')->name('home');
                });", FILE_APPEND
            );

            $this->info('- Appended `home` route to web.php');

        }
    }
}
