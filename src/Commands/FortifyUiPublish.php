<?php

namespace Ycore\FortifyUi\Commands;

use Illuminate\Console\Command;

class FortifyUiPublish extends Command
{
    protected $signature = 'fortify-ui:publish
        {--all : The kitchen sink; publishes all Laravel Fortify config, migrations, providers and actions}
        ';

    protected $description = 'Publishes Laravel Fortify and FortifyUi configurations';

    protected $stubs;

    public function handle()
    {
    }


}
