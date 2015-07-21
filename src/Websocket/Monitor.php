<?php

namespace GintonicCMS\Websocket;

use Cake\Contoller\Controller;
use Cake\Core\App;
use Cake\Event\EventManagerTrait;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\Router;
use Cake\Routing\DispatcherFactory;
use GintonicCMS\Websocket\Procedure\RegisterProcedure;

// Request
use Cake\Core\Configure;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Network\Session;
class Monitor extends Client
{
    use EventManagerTrait;

    public $topic = 'server';

    public function dispatch($url = '/', $id, $data = [])
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

    public function parse($args)
    {
        $url = $args[0];
        $id = $args[1];
        $data = json_decode($args[2], true);
        $this->dispatch($url, $id, $data);
    }

    /**
     * @param \Thruway\ClientSession $session
     * @param \Thruway\Transport\TransportInterface $transport
     */
    public function onSessionStart($session, $transport)
    {
        $session->subscribe($this->topic, [$this, 'parse']);
    }
}
