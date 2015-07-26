<?php

namespace GintonicCMS\Websocket;

use Thruway\Module\Module;

class Discloser extends Module
{
    public function onSessionStart($session, $transport)
    {
        $this->getCallee()->register($this->session, 'server', [$this, 'callPublish']);
    }

    public function callPublish($args)
    {
        $deferred = new \React\Promise\Deferred();

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
