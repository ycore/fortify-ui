<?php

namespace Ycore\FortifyUi\Commands;

use Illuminate\Console\Command;

class FortifyUiInstall extends Command
{
    protected $signature = 'fortify-ui:install
        {--f|force : Overwrite any existing views previously created}';

    protected $description = 'Install authentication views for FortifyUi';

    protected $stubs;

    public function handle()
    {
    }


}
