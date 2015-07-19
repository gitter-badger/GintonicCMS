<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Core\Plugin;
use Cake\Event\Event;

class MessagesController extends AppController
{
    public $paginate = ['maxLimit' => 5];


    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('GintonicCMS.Websocket', [
            'index'
        ]);
    }
    /**
     * Called before each action, allows everyone to use the "pages" controller
     * without specific permissions.
     *
     * @param Event $event An Event instance
     * @return void
     * @link http://book.cakephp.org/3.0/en/controllers.html#request-life-cycle-callbacks
     */
    public function beforeFilter(Event $event)
    {
        $user = $this->Auth->user();
        
        // Validate that the given user has access to requested thread
        $threadAccessActions = ['send'];
        $threadAccess = in_array($this->request->params['action'], $threadAccessActions);
        if ($threadAccess) {
            $threadId = $this->request->data['thread_id'];
            if ($this->Messages->Threads->isRegistered($threadId, $user['id'])) {
                $this->Auth->allow();
            }
        }
        parent::beforeFilter($event);
    }

    public function index()
    {
        $this->render(false);
        $this->set('_ws', ['carottes']);
        debug($this->request->data);
    }
    /**
     * Adds a message to a thread. The request data must define the threadId and
     * the message will be registered to the name of the authenticated user
     */
    public function send()
    {
        $success = false;
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Auth->user();
            $this->request->data['user_id'] = $user['id'];
            $message = $this->Messages->newEntity(
                $this->request->data
            );
            $success = true;//$this->Messages->save($message);
        }
        $this->set(compact('success'));
        $this->set('_serialize', ['success']);

        //$this->autoRender = false;
        //$threadUsers = $this->Messages->Threads->find('participants', [
        //    'threadId' => $this->request->data['thread_id']
        //]);
        //
        //foreach ($threadUsers as $key => $user) {
        //    $this->request->data['message_read_statuses'][] = [
        //        'user_id' => $user['_matchingData']['Users']['id'],
        //        'status' => 0
        //    ];
        //}
    }

    ///**
    // * TODO: Write Document. this method only mark as read.
    // */
    //public function read()
    //{
    //    $this->autoRender = false;
    //    $status['status'] = 'fail';
    //    $userId = $this->request->Session()->read('Auth.User.id');
    //    
    //    if ($this->Messages->markAsRead($this->request->data['messageIds'], $userId)) {
    //        $status['status'] = 'ok';
    //    }
    //    echo json_encode($status);
    //}

    ///**
    // * TODO: Write Document. this method only mark as read.
    // */
    //public function delete()
    //{
    //    $this->autoRender = false;
    //    $status['status'] = 'fail';
    //    $userId = $this->request->Session()->read('Auth.User.id');
    //    
    //    if ($this->Messages->markAsDelete($this->request->data['messageIds'], $userId)) {
    //        $status['status'] = 'ok';
    //    }
    //    echo json_encode($status);
    //}

    ///**
    // * TODO: Write Document. this method only mark as read.
    // */
    //public function unread()
    //{
    //    $this->autoRender = false;
    //    $status['status'] = 'fail';
    //    $userId = $this->request->Session()->read('Auth.User.id');
    //    
    //    if ($this->Messages->markAsUnread($this->request->data['messageIds'], $userId)) {
    //        $status['status'] = 'ok';
    //    }
    //    echo json_encode($status);
    //}
}
