<?php
namespace GintonicCMS\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \GintonicCMS\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        $action = $this->Crud->action();
        $action->config('scaffold.fields_blacklist', ['password', 'token']);
    }
}
