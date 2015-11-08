<?php
namespace GintonicCMS\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Composer\Console\Application as Composer;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * Update shell command.
 */
class InstallShell extends Shell
{
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        $connections = ConnectionManager::configured();
        if (empty($connections)) {
            $this->out('Your database configuration was not found.');
            $this->out('Add your database connection information to config/app.php.');
            return false;
        }

        $this->composer('install');

        $this->migrate();
        $this->migrate('Users');
        $this->migrate('Posts');
        $this->migrate('Messages');
        $this->migrate('Acl');

        $this->permissions();
    }

    /**
     * todo
     */
    public function composer($command)
    {
        $input = new ArrayInput(['command' => $command]);
        $application = new Composer();
        $application->setAutoExit(false);
        $application->run($input);
    }

    /**
     * todo
     */
    public function migrate($plugin = null)
    {
        $plugin = ($plugin === null)? '' : ' -p ' . $plugin;
        $this->dispatchShell('GintonicCMS.migrations migrate' . $plugin);
    }

    /**
     * todo
     */
    public function permissions()
    {
        Configure::write('Acl.classname', 'Acl\Adapter\DbAcl');
        $this->dispatchShell('acl_extras aco_sync');
    }
}
