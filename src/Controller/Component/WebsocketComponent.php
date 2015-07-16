<?php
namespace GintonicCMS\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Network\Response;
use GintonicCMS\Websocket\Trigger;

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
        $hooks = $this->config();
        if (!in_array($action, $hooks)) {
            return;
        }

        $trigger = new Trigger($this->_controller);
        $trigger->publish($event->subject()->viewVars['_ws']);
    }
}
