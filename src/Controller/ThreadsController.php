<?php
namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;

/**
 * Threads Controller
 *
 * @property \Messages\Model\Table\ThreadsTable $Threads
 */
class ThreadsController extends AppController
{
    public $paginate = [
        'limit' => 5,
    ];

    /**
     * Setting $this->Threads to the model in the Messages plugin
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadModel('Messages.Threads');
    }

    /**
     * The threads index page is populated via javascript + the API.
     *
     * @param int $id Thread id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($id === null || !$this->Threads->get($id)) {
            $id = $this->Threads->find()
                ->find('participating', [$this->Auth->user('id')])
                ->order(['Threads.modified' => 'DESC'])
                ->extract('id')
                ->first();
        }
        $this->set(compact('id'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $userId = $this->Auth->user('id');
            $thread = $this->Threads->open($userId, $this->request->data);
            if ($thread) {
                $this->set([
                    'success' => true,
                    'data' => ['id' => $thread->id],
                ]);
                if (!$this->request->params['isAjax']) {
                    $this->setAction('index');
                }
                return;
            }
        }
        $this->set(['success' => false]);
    }
}
