<?php

namespace GintonicCMS\Websocket;

use Cake\Contoller\Controller;
use Cake\Core\App;
use Thruway\Peer\Client;
use Thruway\Logging\Logger;
use Thruway\Transport\PawlTransportProvider;

class Websocket extends Client
{
    public $name = null;
    public $timeout = 5;

    public $publish = [];

    public function __construct($Controller = null, $config = [])
    {
        parent::__construct('realm1');
        $this->_loadName();
        $this->_controller = $Controller;
        $this->addTransportProvider(new PawlTransportProvider("ws://127.0.0.1:9090/"));
    }

    protected function _loadName()
    {
        list(, $name) = namespaceSplit(get_class($this));
        $this->name = substr($name, 0, -9);
    }

    protected function _loadController($session)
    {
        $class = App::className(
            'GintonicCMS.' . $this->name,
            'Controller',
            'Controller'
        );
        $controller = new $class; 
        $actions = $this->_mapActions($controller);
        $this->_loadWsSubscribes($controller, $session);
        $this->_loadWsRegisters($controller, $session);
    }

    // This should fetch the config data
    protected function _mapActions($controller)
    {
        $actions = [];
        $className = get_class($controller);
        $class = new \ReflectionClass($className);
        foreach ($class->getMethods() as $m) {
            // Remove beforeFilter and such
            if ($m->class == $className && $m->name[0] != '_') {
                $actions[] = $m->name;
            }
        }
        return $actions;
    }

    /**
     * Monitor what happens between users
     *
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    protected function _loadWsSubscribes($controller, $actions, $session)
    {
        foreach ($this->_actions as $action) {
            $session->subscribe(
                $this->_uri($action),
                $this->_controller->{$action}
            );
        }
    }

    /**
     * Allow Front-end to call back-end with a response
     *
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    protected function _loadWsRegisters($controller, $actions, $session)
    {
        foreach ($this->_actions as $action) {
            $session->register(
                $this->_uri($action),
                $this->_controller->{$action}
            );
        }
    }

    protected function _uri($action)
    {
        return strtolower($this->_controller->modelClass . '.' . $action);
    }

    public function execute()
    {
        $this->start(false);
        $this->getLoop()->addTimer($this->timeout, [$this, 'kill']);
        $this->getLoop()->run();
    }

    public function kill()
    {
        $this->getLoop()->stop();
    }

    /**
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    public function onSessionStart($session, $transport)
    {
        //if ($this->_controller == null) {
        //    $this->_loadController();
        //}
        
        $this->loadPublish();
    }

    public function addPublish($topicName, array $arguments = [], array $argumentsKw = [])
    {
        $this->publish[] = [
            $topicName,
            $arguments,
            $argumentsKw,
            ["acknowledge" => true]
        ];
    }

    public function loadPublish()
    {
        foreach ($this->publish as $publish) {
            $this->session->publish(
                $publish[0],
                $publish[1],
                $publish[2],
                $publish[3]
            )->then([$this, 'acknowledge'],[$this, 'acknowledge']);
        }
    }

    public function publish($args = [])
    {
        if (!is_array($args)) {
            $args = [$args];
        }
        $topic = $this->_uri($this->_controller->request->action);
        $this->addPublish($topic, $args);
        $this->execute();
    }


    // After a successful call we recieve the data here
    public function call_result($result = null)
    {
        $this->getLoop()->stop();
    }

    public function acknowledge($error = null)
    {
        debug('acknowledgment recieved');
        if ($error != null) {
            debug($error);
        }
        $this->getLoop()->stop();
    }
}
