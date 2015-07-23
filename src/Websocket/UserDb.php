<?php

namespace GintonicCMS\Websocket;

use Cake\Controller\Controller;
/**
 * Class UserDb
 */
class UserDb implements \Thruway\Authentication\WampCraUserDbInterface
{

    /**
     * @var Controller
     */
    private $controller;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->controller = new Controller();
        $this->controller->loadModel('Users');
    }

    /**
     * Get user by id
     * 
     * @param string $authId Username
     * @return boolean
     */
    function get($id)
    {
        if($id == 'server'){
            return ["authid" => 'server', "key" => 'server' , "salt" => null];
        }
        $user = $this->controller->Users->findById($id)->first();
        if ($user) {
            return ["authid" => $user->id, "key" => $user->email, "salt" => null];
        }
        return false;
    }
} 
