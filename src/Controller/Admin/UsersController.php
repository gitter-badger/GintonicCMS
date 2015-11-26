<?php
namespace GintonicCMS\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Permissions\Model\Entity\Role;

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
        $this->Users->hasOne('Roles', [
            'className' => 'Permissions.Roles',
        ]);

        $action = $this->Crud->action();
        $action->config('scaffold.fields_blacklist', ['password', 'token']);
        $action->config('scaffold.fields', [
            'id',
            'email',
            'username',
            'verified',
            'deleted',
            'role.role' => [
                'formatter' => function ($name, $value, $entity) {
                    if (isset($entity->role)) {
                        return $entity->role->names($entity->role->role);
                    }
                    return 'User';
                },
                'options' => Role::names(),
            ],
        ]);
        $this->Crud->listener('relatedModels')->relatedModels(['Roles'], 'index');
    }

    public function index()
    {
        $action = $this->Crud->action();
        $action->config('scaffold.fields_blacklist', ['created', 'modified']);
        return $this->Crud->execute();
    }

    public function view()
    {
        $action = $this->Crud->action();
        $action->config('scaffold.relations');
        return $this->Crud->execute();
    }
}
