<?php
namespace GintonicCMS\Controller;

use App\Controller\AppController;

/**
 * Posts Controller
 *
 * @property \Posts\Model\Table\PostsTable $Posts
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
        $this->loadModel('Posts.Posts');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('posts', $this->paginate($this->Posts));
        $this->set('_serialize', ['posts']);
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($slug)
    {
        $post = $this->Posts->find('slugged', ['slug' => $slug]);
        $this->set('post', $post);
        $this->set('_serialize', ['post']);
    }
}
