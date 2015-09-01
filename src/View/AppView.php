<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace GintonicCMS\View;

use Cake\Core\App;
use Cake\View\View;
use CrudView\View\CrudView;

/**
 * App View class
 */
class AppView extends CrudView
{

    /**
     * Return all possible paths to find view files in order
     *
     * This method overrides cakephp's default method because it doesn't allow
     * to override themes by default
     *
     * @param string|null $plugin Optional plugin name to scan for view files.
     * @param bool $cached Set to false to force a refresh of view paths. Default true.
     * @return array paths
     */
    protected function _paths($plugin = null, $cached = true)
    {
        $paths = parent::_paths($plugin, $cached);

        $templatePaths = App::path('Template');
        $themeOverridePaths = [];
        if (!empty($this->theme)) {
            for ($i = 0, $count = count($templatePaths); $i < $count; $i++) {
                $themeOverridePaths[] = $templatePaths[$i] . $this->theme . DS;
                if ($plugin) {
                    $themedPluginOverride = end($themeOverridePaths) . 'Plugin' . DS . $plugin . DS;
                    array_unshift($themeOverridePaths, $themedPluginOverride);
                }
            }
        }
        
        $paths = array_merge(
            $themeOverridePaths,
            $paths
        );

        return $this->_paths = $paths;
    }
}
