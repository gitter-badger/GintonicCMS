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
Plugin::load('ADmad/Glide', ['bootstrap' => true]);
Configure::write('Glide.serverConfig.source', ROOT . DS . 'uploads/');
DispatcherFactory::add('ADmad/Glide.Glide', ['for' => '/images']);

// Themes
Plugin::load('AdminTheme');
Plugin::load('TwbsTheme');

// Users Management
Plugin::load('Users', ['routes' => true, 'bootstrap' => 'true']);
Plugin::load('FOC/Authenticate');

// Application base
Plugin::load('Messages', ['routes' => true, 'bootstrap' => 'true']);



