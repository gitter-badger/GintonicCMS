<?php

namespace GintonicCMS\Websocket;

use Cake\Contoller\Controller;
use Cake\Core\App;

class Trigger extends Client
{
    public $_controller;
    public $_call;

    public function __construct($controller)
    {
        parent::__construct();
        $this->_controller = $controller;
    }

    /**
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    public function onSessionStart($session, $transport)
    {
        $session->publish(
            $this->_call[0],
            $this->_call[1],
            $this->_call[2],
            $this->_call[3]
        )->then([$this, 'success'],[$this, 'error']);
    }

    public function publish($args = [], $argsKw = [])
    {
        $topic = $this->_uri($this->_controller->name, $this->_controller->request->action);
        if (!is_array($args)) {
            $args = [$args];
        }
        if (!is_array($argsKw)) {
            $argsKw = [$argsKw];
        }
        $this->_call = [$topic, $args, $argsKw, ["acknowledge" => true]];
        $this->execute();
    }

    public function success()
    {
        debug('acknowledgment recieved');
        $this->getLoop()->stop();
    }

    public function error($error)
    {
        if ($error != null) {
            debug($error);
        }
        $this->getLoop()->stop();
    }
}
