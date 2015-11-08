<?php
namespace GintonicCMS\Controller\Admin;

use App\Controller\Admin\AppController;
use Posts\Model\Entity\Post;
use Cake\Event\Event;

/**
 * Posts Controller
 *
 * @property \GintonicCMS\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        $action = $this->Crud->action();
        $action->config('scaffold.extra_buttons_blacklist', [
            'save_and_continue', 
            'save_and_create',
            'back',
        ]);
    }

    public function add()
    {
        $action = $this->Crud->action();
        $action->config('scaffold.fields', [
            'title',
            'body',
            'intro',
            'status' => [
                'formatter' => function ($name, $value, $entity) {
                    return $entity->statuses($value);
                },
                'type' => 'select',
                'options' => Post::statuses(),
            ],
        ]);
        return $this->Crud->execute();
    }
}
