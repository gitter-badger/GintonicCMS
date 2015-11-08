<?php

use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'GintonicCMS'], function ($routes) {

    $routes->fallbacks('DashedRoute');

    $routes->prefix('admin', function ($routes) {

        $routes->connect('/users', ['controller' => 'Users']);
        $routes->connect('/users/:action/*', ['controller' => 'Users']);


        $routes->connect('/posts', ['controller' => 'Posts']);
        $routes->connect('/posts/:action/*', ['controller' => 'Posts']);

        $routes->fallbacks('DashedRoute');
    });

});
