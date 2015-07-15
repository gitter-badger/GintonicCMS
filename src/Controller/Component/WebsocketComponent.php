<?php
namespace GintonicCMS\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Network\Response;
use GintonicCMS\Websocket\Websocket;

/**
 * Websocket component
 *
 * Hook controller actions to a Websockets front-end
 * implementing (WAMP) 
 */
class WebsocketComponent extends Component
{

    /**
     * Reference to the current controller.
     *
     * @var \Cake\Controller\Controller
     */
    protected $_controller;

    /**
     * Reference to the current event manager.
     *
     * @var \Cake\Event\EventManager
     */
    protected $_eventManager;

    protected $requestTypes = ['subscribe', 'publish', 'register', 'call'];

    /**
     * Components settings.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function __construct(ComponentRegistry $collection, $config = [])
    {
        $this->_controller = $collection->getController();
        $this->_eventManager = $this->_controller->eventManager();
        parent::__construct($collection, $config);
    }

    public function shutdown(Event $event)
    {

        $action = $event->subject()->request->action;
        $requestType = $this->config($action);

        // Action not registered
        if (!$action){
            return;
        }

        // Request type error
        if (!$requestType || !in_array($requestType, $this->requestTypes)){
            // TODO: throw error
            return;
        }

        $websocket = new Websocket($this->_controller);
        $websocket->{$requestType}($event->subject()->viewVars['_ws']);
    }
}
