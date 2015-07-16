<?php

namespace GintonicCMS\Websocket;

use Cake\Contoller\Controller;
use Cake\Core\App;
use Cake\Network\Request;
use GintonicCMS\Websocket\Procedure\PublishProcedure;
use Thruway\Peer\Client as ThruwayClient;
use Thruway\Logging\Logger;
use Thruway\Transport\PawlTransportProvider;

class Client extends ThruwayClient
{
    public $timeout = 5;

    public function __construct()
    {
        parent::__construct('realm1');
        $this->addTransportProvider(new PawlTransportProvider("ws://127.0.0.1:9090/"));
    }

    protected function _uri($controller, $action)
    {
        return strtolower($controller . '.' . $action);
    }

    public function execute()
    {
        $this->start(false);
        $this->getLoop()->addTimer($this->timeout, [$this, 'kill']);
        $this->getLoop()->run();
    }

    public function kill()
    {
        debug('killed');
        $this->getLoop()->stop();
    }
}
