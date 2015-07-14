<?php

namespace GintonicCMS\Websocket;

use Cake\Contoller\Controller;
use Cake\Core\App;
use Cake\Core\ClassLoader;
use Cake\Core\InstanceConfigTrait;
use Cake\Event\EventListenerInterface;
use Thruway\Peer\Client;

class Websocket extends Client implements EventListenerInterface
{

    use InstanceConfigTrait;

    public $name = null;
    protected $_controller;
    protected $_defaultConfig = [];
    private $_actions = [];

    public function __construct($Controller, $config = [])
    {
        $this->_loadName();
        $this->_loadController($Controller);
        $this->_mapActions();
        $this->config($config);
        parent::__construct('realm1');
    }

    /**
     * List of implemented events
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [];
    }

    /**
     * Convenient method for Request::is
     *
     * @param string|array $method Method(s) to check for
     * @return bool
     */
    protected function _checkRequestType($method)
    {
        return $this->_request()->is($method);
    }

    protected function _loadName()
    {
        list(, $name) = namespaceSplit(get_class($this));
        $this->name = substr($name, 0, -9);
    }

    protected function _loadController($Controller = null)
    {
        if ($Controller === null) {
            $class = App::className(
                'GintonicCMS.' . $this->name,
                'Controller',
                'Controller'
            );
            $this->_controller = new $class; 
        } else {
            $this->_controller = $Controller; 
        }
    }

    protected function _mapActions()
    {
        $className = get_class($this->_controller);
        $class = new \ReflectionClass($className);
        foreach ($class->getMethods() as $m) {
            // Remove beforeFilter and such
            if ($m->class == $className && $m->name[0] != '_') {
                $this->_actions[] = $m->name;
            }
        }
    }

    /**
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    protected function _loadWsSubscribes($session, $transport)
    {
        foreach ($this->_actions as $action) {
            $session->subscribe(
                $this->_uri($action),
                $this->_controller->{$action}
            );
        }
    }

    /**
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    protected function _loadWsRegisters($session, $transport)
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
        return strtolower($this->name . '.' . $action);
    }

    /**
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    public function onSessionStart($session, $transport)
    {
        // 1) subscribe to topics
        $this->_loadWsSubscribes($session, $transport);

        //// 2) publish an event
        //$session->publish('com.myapp.hello', ['Hello, world from PHP!!!'], [], ["acknowledge" => true])->then(
        //    function () {
        //        echo "Publish Acknowledged!\n";
        //    },
        //    function ($error) {
        //        // publish failed
        //        echo "Publish Error {$error}\n";
        //    }
        //);

        //// 3) register a procedure for remoting
        $this->_loadWsRegisters($session, $transport);

        //// 4) call a remote procedure
        //$session->call('com.myapp.add2', [2, 3])->then(
        //    function ($res) {
        //        echo "Result: {$res}\n";
        //    },
        //    function ($error) {
        //        echo "Call Error: {$error}\n";
        //    }
        //);
    }
}
