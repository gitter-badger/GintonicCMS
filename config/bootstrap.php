<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\DispatcherFactory;

Plugin::load('Acl', ['bootstrap' => true]);

// Crud stack
Plugin::load('BootstrapUI');
Plugin::load('Crud');
Plugin::load('CrudView');
Plugin::load('Search');

// Javascript
Plugin::load('Requirejs');
Plugin::load('Websockets', ['bootstrap' => true]);
Configure::write('Websockets.userModel', 'Users.Users');
Configure::write('Websockets.scope', false);

// File management
Plugin::load('Josegonzalez/Upload');
Plugin::load('ADmad/Glide');
Configure::write('Glide', [
    'serverConfig' => [
        'base_url' => '/images/',
        'source' => ROOT . DS . 'uploads/',
        'cache' => WWW_ROOT . 'cache',
        'response' => new ADmad\Glide\Responses\CakeResponseFactory(),
    ],
    'secureUrls' => true,
]);

DispatcherFactory::add('ADmad/Glide.Glide', ['for' => '/images']);

// Themes
Plugin::load('AdminTheme');
Plugin::load('TwbsTheme');

// Users Management
Plugin::load('Users', ['routes' => true, 'bootstrap' => 'true']);
Plugin::load('FOC/Authenticate');
Plugin::load('Permissions', ['routes' => true]);

// Application base
Plugin::load('Messages', ['routes' => true, 'bootstrap' => 'true']);



