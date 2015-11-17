<?php
namespace GintonicCMS\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Event\Event;
use Posts\Model\Entity\Post;

/**
 * Posts Controller
 *
 * @property \GintonicCMS\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
    /**
     * Making sure that we use the Posts plugin's model layer
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Posts.Posts');
    }

    /**
     * Disables the extra crud-view buttons so that we only keep 'save'
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $action = $this->Crud->action();
        $action->config('scaffold.extra_buttons_blacklist', [
            'save_and_continue',
            'save_and_create',
            'back',
        ]);
    }

    /**
     * Setting the 'status' dropdown to the options from the model
     *
     * @return void
     */
    public function index()
    {
        return $this->Crud->execute();
    }

    /**
     * Setting the 'status' dropdown to the options from the model
     *
     * @return void
     */
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
