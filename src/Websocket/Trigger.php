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

    /**
     * TODO doc block
     */
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
        //);
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

    /**
     * TODO doc block
     */
    public function publish($args = [], $users = null)
    {
        $argsKw = [], 
        $topic = $this->_uri($this->_controller->name, $this->_controller->request->action);
        if (!is_array($args)) {
            $args = [$args];
        }

        $this->_users = $users;
        $this->_call = [$topic, $args, $argsKw, ["acknowledge" => true]];
        $this->execute();
    }

    /**
     * TODO doc block
     */
    public function success()
    {
        debug('acknowledgment recieved');
        $this->getLoop()->stop();
    }

    /**
     * TODO doc block
     */
    public function error($error)
    {
        if ($error != null) {
            debug($error);
        }
        $this->getLoop()->stop();
    }
}
