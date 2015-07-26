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
#use Thruway\Authentication\ClientWampCraAuthenticator;

use Thruway\Peer\Client;

class Monitor extends Client
{
    /**
     * TODO doc block
     */
    public $topic = 'server';

    /**
     * TODO doc block
     */
    //public function __construct()
    //{
    //    parent::__construct();
    //    //$this->setAuthId('server');
    //    //$this->addClientAuthenticator(new ClientWampCraAuthenticator('server', 'server'));
    //}

    /**
     * TODO doc block
     */
    public function dispatch($url = '/', $id = null, $data = [])
    {
        $base = '';
        $webroot = '/';
        $sessionConfig = (array)Configure::read('Session') + [
            'defaults' => 'php',
            'cookiePath' => $webroot
        ];

        $config = [
            'query' => $_GET,
            'post' => $data,
            'files' => $_FILES,
            'cookies' => $_COOKIE,
            'environment' => ['REQUEST_METHOD' => 'POST'],
            'base' => $base,
            'webroot' => $webroot,
            'session' => Session::create($sessionConfig)
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
        debug($args);
        $url = $args[0];
        $id = $args[1];
        $data = json_decode($args[2], true);
        $this->dispatch($url, $id, $data);
    }

    /**
     * @param \Thruway\ClientSession $session the user session
     * @param \Thruway\Transport\TransportInterface $transport the transport
     */
    public function onSessionStart($session, $transport)
    {
        $session->subscribe($this->topic, [$this, 'parse']);
    }
}
