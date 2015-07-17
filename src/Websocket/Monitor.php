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

    public function dispatch($url = '/', $data = [])
    {
        echo var_dump($data);
        $base = '';
        $webroot = '/';
        $sessionConfig = (array)Configure::read('Session') + [
            'defaults' => 'php',
            'cookiePath' => $webroot
        ];

        $config = [
            'query' => $_GET,
            'post' => $_POST,
            'files' => $_FILES,
            'cookies' => $_COOKIE,
            'environment' => $_SERVER + $_ENV,
            'base' => $base,
            'webroot' => $webroot,
            'session' => Session::create($sessionConfig)
        ];
        $config['url'] = $url . '.json';

        $request = new Request($config);

        //$dispatcher = DispatcherFactory::create();
        //$dispatcher->dispatch(
        //    $request,
        //    new Response()
        //);
    }

    public function parse($args)
    {
        $url = $args[0];
        $data = json_decode($args[1]);
        $this->dispatch($url, $data);
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
