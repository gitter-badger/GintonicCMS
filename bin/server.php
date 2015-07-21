<?php

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

use GintonicCMS\Websocket\UserDb;
use Thruway\Authentication\WampCraAuthProvider;
use Thruway\Peer\Router;
use Thruway\Transport\RatchetTransportProvider;

$router = new Router();


// setup some users to auth against
$userDb = new UserDb();
$userDb->add('peter', 'secret1', 'salt123');
$userDb->add('joe', 'secret2', "mmm...salt");

$authMgr = new \Thruway\Authentication\AuthenticationManager();
$router->setAuthenticationManager($authMgr);
$router->addInternalClient($authMgr);

$authProvClient = new WampCraAuthProvider(["realm1"]);
$authProvClient->setUserDb($userDb);
$router->addInternalClient($authProvClient);





$transportProvider = new RatchetTransportProvider("127.0.0.1", 9090);
$router->addTransportProvider($transportProvider);
$router->start();
