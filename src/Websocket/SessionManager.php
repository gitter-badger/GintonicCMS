<?php

namespace GintonicCMS\Websocket;

use Thruway\Peer\Client;

class SessionManager extends Client extends Module
{
    public $sessions = [];

    /**
     * @param \Thruway\ClientSession $session ClientSession
     * @param \Thruway\Transport\TransportInterface $transport Transport
     */
    public function onSessionStart($session, $transport)
    {
        $session->subscribe('wamp.metaevent.session.on_join', [$this, 'onJoin']);
        $session->subscribe('wamp.metaevent.session.on_leave', [$this, 'onLeave']);
        $session->register('server.get_user_sessions', [$this, 'getUserSession']);
        $session->register('server.get_user_id', [$this, 'getUserId']);
        $this->getCallee()->register($this->session, 'server', [$this, 'callPublish']);
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
        if (!isset($this->sessions[$args[0]->authid])) {
            return;
        }

        foreach ($this->sessions[$args[0]->authid] as $k => $session) {
            if ($session === $args[0]->session) {
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

    /**
     * TODO doc block
     */
    public function getUserId($args)
    {
        debug('into getUserId');
        foreach($this->sessions as $users) {
            if(array_search($args[0]->sessionId, $users)){
                return $users;
            }
        }
        return false;
    }

    public function callPublish($args)
    {
        $deferred = new \React\Promise\Deferred();

        debug($this->sessions);
        debug('retrieving user id');
        //$this->session->getSessionId()
        $this->getCaller()->call($this->session, 'server.get_user_session', 1)->then(
            function ($res) {
                debug($res);exit;
            }
        );
        debug('user not found');
        debug($args);
        //$this->getPublisher()->publish($this->session, "server", [$args[0]], ["key1" => "test1", "key2" => "test2"],
        //    ["acknowledge" => true])
        //    ->then(
        //        function () use ($deferred) {
        //            $deferred->resolve('ok');
        //        },
        //        function ($error) use ($deferred) {
        //            $deferred->reject("failed: {$error}");
        //        }
        //    );

        //return $deferred->promise();
        return true;
    }
}
