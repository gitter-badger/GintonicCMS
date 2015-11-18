<?php
namespace GintonicCMS\Shell;

use Cake\Cache\Cache;
use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Composer\Console\Application as Composer;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * Update shell command.
 */
class GintonicShell extends Shell
{
    /**
     * {@inherit}
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function install()
    {
        $connections = ConnectionManager::configured();
        if (empty($connections)) {
            $this->out('Your database configuration was not found.');
            $this->out('Add your database connection information to config/app.php.');
            return false;
        }

        $this->migrate();
        $this->migrate('Users');
        $this->migrate('Posts');
        $this->migrate('Messages');
        $this->migrate('Permissions');

        $this->symlinks();
        $this->permissions();

        $this->cleanup();
    }

    /**
     * todo
     */
    public function cleanup()
    {
        Cache::clear(false, 'default');
        Cache::clear(false, '_cake_model_');
        Cache::clear(false, '_cake_core_');
        $this->dispatchShell('orm_cache clear');
        $this->dispatchShell('orm_cache build');
    }

    /**
     * todo
     */
    public function symlinks($plugin = null)
    {
        $this->dispatchShell('plugin assets symlink');
    }

    /**
     * todo
     */
    public function migrate($plugin = null)
    {
        $plugin = ($plugin === null)? '' : ' -p ' . $plugin;
        $this->dispatchShell('migrations migrate' . $plugin);
    }
}
