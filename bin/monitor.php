<?php

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__).'/../../../config/bootstrap.php';

use GintonicCMS\Websocket\Monitor;

$client = new Monitor();
$client->start();
