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
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Aros');
    }
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

        $this->composer('update');

        $this->createAppConfig();
        $this->createWritableDirectories();
        $this->setFolderPermissions();
        $this->setSecuritySalt();

        $this->migrate();
        $this->migrate('Users');
        $this->migrate('Posts');
        $this->migrate('Messages');
        $this->migrate('Acl');

        $this->symlinks();
        $this->permissions();

        $this->setRole('admin');
        $this->setRole('user');
        $this->setRole('visitor');

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

    /**
     * todo
     */
    public function setRole($role)
    {
        $count = $this->Aros->find()->where(['alias' => $role])->count();
        if(!$count) {
            $this->dispatchShell('acl create aro root ' . $role);
        }
    }
    /**
     * todo
     */
    public function permissions()
    {
        Configure::write('Acl.classname', 'Acl\Adapter\DbAcl');
        $this->dispatchShell('acl_extras aco_sync');
    }
    /**
     * Create the config/app.php file if it does not exist.
     *
     * @return void
     */
    public function createAppConfig()
    {
        $appConfig = ROOT . '/config/app.php';
        $defaultConfig = ROOT . '/config/app.default.php';
        if (!file_exists($appConfig)) {
            copy($defaultConfig, $appConfig);
            $this->out('Created `config/app.php` file');
        }
    }

    /**
     * Create the `logs` and `tmp` directories.
     *
     * @return void
     */
    public function createWritableDirectories()
    {
        $paths = [
            'logs',
            'tmp',
            'tmp/cache',
            'tmp/cache/models',
            'tmp/cache/persistent',
            'tmp/cache/views',
            'tmp/sessions',
            'tmp/tests',
            'uploads',
            'webroot/cache'
        ];

        foreach ($paths as $path) {
            $path = ROOT . '/' . $path;
            if (!file_exists($path)) {
                mkdir($path);
                $this->out('Created `' . $path . '` directory');
            }
        }
    }

    /**
     * Set globally writable permissions on the "tmp" and "logs" directory.
     *
     * This is not the most secure default, but it gets people up and running quickly.
     *
     * @return void
     */
    public function setFolderPermissions()
    {
        // Change the permissions on a path and output the results.
        $changePerms = function ($path, $perms) {
            // Get current permissions in decimal format so we can bitmask it.
            $currentPerms = octdec(substr(sprintf('%o', fileperms($path)), -4));
            if (($currentPerms & $perms) == $perms) {
                return;
            }

            $res = chmod($path, $currentPerms | $perms);
            if ($res) {
                $this->out('Permissions set on ' . $path);
            } else {
                $this->out('Failed to set permissions on ' . $path);
            }
        };

        $walker = function ($dir, $perms) use (&$walker, $changePerms) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $path = $dir . '/' . $file;

                if (!is_dir($path)) {
                    continue;
                }

                $changePerms($path, $perms);
                $walker($path, $perms);
            }
        };

        $worldWritable = bindec('0000000111');
        $walker(ROOT . '/tmp', $worldWritable);
        $walker(ROOT . '/uploads', $worldWritable);
        $walker(ROOT . '/webroot/cache', $worldWritable);
        $changePerms(ROOT . '/tmp', $worldWritable);
        $changePerms(ROOT . '/logs', $worldWritable);
        $changePerms(ROOT . '/uploads', $worldWritable);
        $changePerms(ROOT . '/webroot/cache', $worldWritable);
    }

    /**
     * Set the security.salt value in the application's config file.
     *
     * @return void
     */
    public function setSecuritySalt()
    {
        $config = ROOT . '/config/app.php';
        $content = file_get_contents($config);

        $newKey = hash('sha256', ROOT . php_uname() . microtime(true));
        $content = str_replace('__SALT__', $newKey, $content, $count);

        if ($count == 0) {
            $this->out('No Security.salt placeholder to replace.');
            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $this->out('Updated Security.salt value in config/app.php');
            return;
        }
        $this->out('Unable to update Security.salt value.');
    }
}
