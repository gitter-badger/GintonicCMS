<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         1.2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\View;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Network\Request;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use GintonicCMS\View\AppView;


/**
 * ViewPostsController class
 *
 */
class ViewPostsController extends Controller
{

    /**
     * name property
     *
     * @var string
     */
    public $name = 'Posts';

    /**
     * uses property
     *
     * @var mixed
     */
    public $uses = null;

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->set([
            'testData' => 'Some test data',
            'test2' => 'more data',
            'test3' => 'even more data',
        ]);
    }

    /**
     * nocache_tags_with_element method
     *
     * @return void
     */
    public function nocache_multiple_element()
    {
        $this->set('foo', 'this is foo var');
        $this->set('bar', 'this is bar var');
    }
}

/**
 * ThemePostsController class
 *
 */
class ThemePostsController extends Controller
{
    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('testData', 'Some test data');
        $test2 = 'more data';
        $test3 = 'even more data';
        $this->set(compact('test2', 'test3'));
    }
}

/**
 * TestView class
 *
 */
class TestView extends AppView
{
    public function initialize()
    {
        $this->loadHelper('Html', ['mykey' => 'myval']);
    }
    /**
     * getViewFileName method
     *
     * @param string $name Controller action to find template filename for
     * @return string Template filename
     */
    public function getViewFileName($name = null)
    {
        return $this->_getViewFileName($name);
    }
    /**
     * getLayoutFileName method
     *
     * @param string $name The name of the layout to find.
     * @return string Filename for layout file (.ctp).
     */
    public function getLayoutFileName($name = null)
    {
        return $this->_getLayoutFileName($name);
    }
    /**
     * paths method
     *
     * @param string $plugin Optional plugin name to scan for view files.
     * @param bool $cached Set to true to force a refresh of view paths.
     * @return array paths
     */
    public function paths($plugin = null, $cached = true)
    {
        return $this->_paths($plugin, $cached);
    }
    /**
     * Setter for extension.
     *
     * @param string $ext The extension
     * @return void
     */
    public function ext($ext)
    {
        $this->_ext = $ext;
    }
}

/**
 * ViewTest class
 *
 */
class ViewTest extends TestCase
{

    /**
     * Fixtures used in this test.
     *
     * @var array
     */
    public $fixtures = ['plugin.GintonicCMS.users'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $request = new Request();
        $this->Controller = new Controller($request);
        $this->PostsController = new ViewPostsController($request);
        $this->PostsController->index();
        $this->View = $this->PostsController->createView();
        $this->View->viewPath = 'Posts';

        $themeRequest = new Request('posts/index');
        $this->ThemeController = new Controller($themeRequest);
        $this->ThemePostsController = new ThemePostsController($themeRequest);
        $this->ThemePostsController->index();
        $this->ThemeView = $this->ThemePostsController->createView();
        $this->ThemeView->viewPath = 'Posts';

        Plugin::load(['TestPlugin', 'TestTheme']);
        Configure::write('debug', true);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Plugin::unload();
        unset($this->View);
        unset($this->PostsController);
        unset($this->Controller);
        unset($this->ThemeView);
        unset($this->ThemePostsController);
        unset($this->ThemeController);
    }

    /**
     * Test that themed plugin paths are generated correctly.
     *
     * @return void
     */
    public function testPathThemedPluginGeneration()
    {
        $viewOptions = ['plugin' => 'TestPlugin',
            'name' => 'TestPlugin',
            'viewPath' => 'Tests',
            'view' => 'index',
            'theme' => 'TestTheme'
        ];

        $View = new TestView(null, null, null, $viewOptions);
        $paths = $View->paths('TestPlugin');
        $pluginPath = Plugin::path('TestPlugin');
        $themePath = Plugin::path('TestTheme');
        $expected = [
            TEST_APP . APP_DIR . DS . 'Template' . DS . 'TestTheme' . DS . 'Plugin' . DS . 'TestPlugin' . DS,
            TEST_APP . APP_DIR . DS . 'Template' . DS . 'TestTheme' . DS,
            $themePath . 'src' . DS . 'Template' . DS . 'Plugin' . DS . 'TestPlugin' . DS,
            $themePath . 'src' . DS . 'Template' . DS,
            TEST_APP . APP_DIR . DS . 'Template' . DS . 'Plugin' . DS . 'TestPlugin' . DS,
            $pluginPath . 'src' . DS . 'Template' . DS,
            TEST_APP . APP_DIR . DS . 'Template' . DS,
            CAKE . 'Template' . DS,
        ];

        $this->assertPathEquals($expected, $paths);
    }
}
