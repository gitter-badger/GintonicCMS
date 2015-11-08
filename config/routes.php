<?php

use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'GintonicCMS'], function ($routes) {

    $routes->connect('/messages', ['controller' => 'Messages']);
    $routes->connect('/threads', ['controller' => 'Threads']);
    $routes->connect('/messages/:action/*', ['controller' => 'Messages'], ['routeClass' => 'DashedRoute']);
    $routes->connect('/threads/:action/*', ['controller' => 'Threads'], ['routeClass' => 'DashedRoute']);
    $routes->fallbacks('DashedRoute');

    $routes->prefix('admin', function ($routes) {

        $routes->connect('/users', ['controller' => 'Users']);
        $routes->connect('/users/:action/*', ['controller' => 'Users']);


        $routes->connect('/posts', ['controller' => 'Posts']);
        $routes->connect('/posts/:action/*', ['controller' => 'Posts']);

        $routes->fallbacks('DashedRoute');
    });

});
