<?php

namespace GintonicCMS\Websocket;

use Thruway\Peer\Client;

class SessionManager extends Client
{
    public $sessions = [];

    /**
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    public function onSessionStart($session, $transport)
    {
        $session->subscribe('wamp.metaevent.session.on_join', [$this, 'onJoin']);
        $session->subscribe('wamp.metaevent.session.on_leave', [$this, 'onLeave']);
        $session->register('server.get_user_sessions', [$this, 'getUserSession']);
    }

    /**
     * TODO doc block
     */
    public function onJoin($args)
    {
        echo var_dump($this->sessions);
        echo var_dump($args[0]->session);
        //echo var_dump($this->sessions[$args[0]->authid]);
        $this->sessions[$args[0]->authid][] = $args[0]->session;
        echo var_dump($this->sessions);
    }

    /**
     * TODO doc block
     */
    public function onLeave($args)
    {
        //remove the session
        if (!isset($this->sessions[$args[0]->authid])){
            return;
        }

        foreach ( $this->sessions[$args[0]->authid] as $k => $session) {
            if ($session === $args[0]->session){
                unset($this->sessions[$args[0]->authid][$k]);
            }
        }
        //$this->sessions[$args[0]->authid] = $args[0]->session;
    }

    /**
     * TODO doc block
     */
    public function getUserSession($args)
    {
        return $this->sessions[$args[0]->authid];
    }
}
