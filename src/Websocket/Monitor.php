<?php

namespace GintonicCMS\Websocket;

use Cake\Contoller\Controller;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Network\Session;
use Cake\Routing\DispatcherFactory;
use Cake\Routing\Router;
use GintonicCMS\Websocket\Procedure\RegisterProcedure;
use Thruway\Peer\Client;

class Monitor extends Client
{
    public $sessions = [];

    /**
     * @param \Thruway\ClientSession $session the user session
     * @param \Thruway\Transport\TransportInterface $transport the transport
     */
    public function onSessionStart($session, $transport)
    {
        $session->subscribe('wamp.metaevent.session.on_join', [$this, 'onJoin']);
        $session->subscribe('wamp.metaevent.session.on_leave', [$this, 'onLeave']);
        $session->register('server.get_user_sessions', [$this, 'getUserSession']);
        $session->register('server', [$this, 'parse']);
    }

    /**
     * TODO doc block
     */
    public function dispatch($auth, $url = '/', $data = [])
    {
        $base = '';
        $webroot = '/';
        $sessionConfig = (array)Configure::read('Session') + [
            'defaults' => 'php',
            'cookiePath' => $webroot
        ];

        $session = Session::create($sessionConfig);
        $session->write(['websocket_user_id' => $auth[0]]);

        $config = [
            'query' => $_GET,
            'post' => $data,
            'files' => $_FILES,
            'cookies' => $_COOKIE,
            'environment' => ['REQUEST_METHOD' => 'POST'],
            'base' => $base,
            'webroot' => $webroot,
            'session' => $session
        ];
        $config['url'] = $url;

        $request = new Request($config);
        $request->addDetector('post', ['env' => 'REQUEST_METHOD', 'value' => 'POST']);

        $dispatcher = DispatcherFactory::create();
        $dispatcher->dispatch(
            $request,
            new Response()
        );
    }

    /**
     * TODO doc block
     */
    public function parse($args)
    {
        $auth = $args[0];
        $destination = $args[1];
        $data = json_decode($args[2], true);
        $this->dispatch($auth, $destination[0], $data);
    }

    /**
     * TODO doc block
     */
    public function onJoin($args)
    {
        $this->sessions[$args[0]->authid][] = $args[0]->session;
        debug($this->sessions);
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
    }

    /**
     * TODO doc block
     */
    public function getUserSession($args)
    {
        return $this->sessions[$args[0]->authid];
    }
}
