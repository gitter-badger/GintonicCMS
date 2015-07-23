<?php

namespace GintonicCMS\Websocket;

use Cake\Contoller\Controller;
use Cake\Core\App;
use Thruway\Authentication\ClientWampCraAuthenticator;

class Trigger extends Client
{
    public $_controller;
    public $_call;
    public $_users;

    public function __construct($controller)
    {
        $this->_controller = $controller;
        $this->setAuthId('server');
        $this->addClientAuthenticator(new ClientWampCraAuthenticator('server','server'));
        parent::__construct();
    }

    /**
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    public function onSessionStart($session, $transport)
    {
        if ($this->users == null) {
            $session->publish(
                $this->_call[0],
                $this->_call[1],
                $this->_call[2],
                $this->_call[3]
            )->then([$this, 'success'],[$this, 'error']);
            return
        }

        //$session->publish(
        //    'messages.send',
        //    ['fdsafd'],
        //    [],
        //    [
        //        "acknowledge" => true,
        //        "eligible" => [5026853095080135]
        //    ]
        //)->then(function(){echo 'aknowledged';});
        $session->call('server.get_user_sessions', $this->_users)->then(
            function ($res) use ($session) {
                $session->publish(
                    $this->_call[0],
                    $this->_call[1],
                    $this->_call[2],
                    array_merge($this->_call[3], ['eligible' => $res[0]])
                )->then([$this, 'success'],[$this, 'error']);
            }
        );

    }

    public function publish($args = [], $argsKw = [], $users = null)
    {
        $topic = $this->_uri($this->_controller->name, $this->_controller->request->action);
        if (!is_array($args)) {
            $args = [$args];
        }
        if (!is_array($argsKw)) {
            $argsKw = [$argsKw];
        }
        if (!is_array($argsKw)) {
            $argsKw = [$argsKw];
        }

        $this->_users = $users;
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