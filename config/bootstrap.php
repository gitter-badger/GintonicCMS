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
Plugin::load('Websockets');

// File management
Plugin::load('Josegonzalez/Upload');
Plugin::load('ADmad/Glide', ['bootstrap' => true]);
Configure::write('Glide.serverConfig.source', ROOT . DS . 'uploads/');
DispatcherFactory::add('ADmad/Glide.Glide', ['for' => '/images']);

// Themes
Plugin::load('AdminTheme');
Plugin::load('TwbsTheme');

// Application base
Plugin::load('Payments', ['routes' => true]);
Plugin::load('Users', ['routes' => true, 'bootstrap' => 'true']);



