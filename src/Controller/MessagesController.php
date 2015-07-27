<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Core\Plugin;
use Cake\Event\Event;

class MessagesController extends AppController
{
    public $paginate = ['maxLimit' => 5];


    /**
     * TODO doc block
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('GintonicCMS.Websocket');
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
        //if ($threadAccess) {
        //    $threadId = $this->request->data['thread_id'];
        //    if ($this->Messages->Threads->isRegistered($threadId, $user['id'])) {
                $this->Auth->allow();
        //    }
        //}
        parent::beforeFilter($event);
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

            $success = $this->Messages->save($message);
            if ($success) {
                $threadId = $message['thread_id'];
                $this->set('_ws', [
                    'users' => $this->Messages->Threads->getUserIds($threadId)->toArray(),
                    'data' => $this->Messages->find('withThreads', [$threadId])->toArray()
                ]);
            }
        }
        $this->set('_serialize', ['success']);

        //foreach ($threadUsers as $key => $user) {
        //    $this->request->data['message_read_statuses'][] = [
        //        'user_id' => $user['_matchingData']['Users']['id'],
        //        'status' => 0
        //    ];
        //}
    }

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
