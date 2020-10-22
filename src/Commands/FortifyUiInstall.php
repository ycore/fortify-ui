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

        $this->comment('Installed FortifyUi views successfully.');
    }

    protected function setStubs()
    {
    }

    protected function clobberViews()
    {
    }

    protected function publishViewStubs()
    {
    }

    protected function addHomeRoute()
    {

    }
}
