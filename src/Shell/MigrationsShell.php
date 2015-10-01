<?php

namespace GintonicCMS\Shell;

use Cake\Console\Shell;
use Migrations\Shell\MigrationsShell as BaseShell;
use Migrations\MigrationsDispatcher;
use Symfony\Component\Console\Input\ArgvInput;

/**
 * {@inherit}
 */
class MigrationsShell extends BaseShell
{
    /**
     * {@inherit}
     */
    public function main()
    {
        $app = new MigrationsDispatcher(PHINX_VERSION);
        $input = new ArgvInput($this->argv);
        $app->setAutoExit(false);
        $app->run($input);
    }
}
