<?php
namespace GintonicCMS\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \GintonicCMS\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * The password and token fields shouldn't be displayed
     * in the admin panel
     */
    public function beforeFilter(Event $event)
    {
        $action = $this->Crud->action();
        $action->config('scaffold.fields_blacklist', ['password', 'token']);
    }

    public function index()
    {
        $this->Crud->on('beforePaginate', function (Event $event) {
            $usersTable = TableRegistry::get('Users.Users');
            $event->subject()->query = $usersTable
                ->find('role')
                ->select($usersTable);
        });

        $action = $this->Crud->action();
        $action->config('scaffold.fields', [
            'id',
            'email',
            'username',
            'verified',
            'role',
            'created',
            'modified',
            'deleted',
            'role' => [
                'formatter' => function ($name, $value, $entity){
                    return $entity['role']['alias'];
                },
            ],
        ]);
        $this->Crud->execute();
    }
}
