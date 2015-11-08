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
Plugin::load('Images', ['routes' => true, 'bootstrap' => true]);

// Themes
Plugin::load('AdminTheme');
Plugin::load('TwbsTheme');

// Users Management
Plugin::load('Users', ['routes' => true, 'bootstrap' => 'true']);
Plugin::load('FOC/Authenticate');
Plugin::load('Permissions', ['routes' => true]);

// Application base
Plugin::load('Posts', ['routes' => true, 'bootstrap' => 'true']);
Plugin::load('Messages', ['routes' => true, 'bootstrap' => 'true']);



