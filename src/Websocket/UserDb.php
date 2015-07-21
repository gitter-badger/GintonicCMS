<?php

namespace GintonicCMS\Websocket;

use Cake\Controller\Controller;
/**
 * Class UserDb
 */
class UserDb implements \Thruway\Authentication\WampCraUserDbInterface
{

    /**
     * @var array
     */
    private $users;

    /**
     * @var Controller
     */
    private $controller;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = [];
        $this->controller = new Controller();
    }

    /**
     * Add new user
     * 
     * @param string $userName
     * @param string $password
     * @param string $salt
     */
    function add($userName, $password, $salt = null)
    {
        $this->controller->loadModel('Users');
        echo var_dump($this->controller);exit;
        if ($salt !== null) {
            $key = \Thruway\Common\Utils::getDerivedKey($password, $salt);
        } else {
            $key = $password;
        }

        $this->users[$userName] = ["authid" => $userName, "key" => $key, "salt" => $salt];
    }

    /**
     * Get user by username
     * 
     * @param string $authId Username
     * @return boolean
     */
    function get($authId)
    {
        if (isset($this->users[$authId])) {
            return $this->users[$authId];
        } else {
            return false;
        }
    }

} 
