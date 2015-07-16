<?php

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__).'/../../../config/bootstrap.php';

use GintonicCMS\Websocket\Monitor;
use Thruway\ClientSession;
use Thruway\Peer\Client;
use Thruway\Transport\PawlTransportProvider;

$client = new Monitor();
$client->start();
