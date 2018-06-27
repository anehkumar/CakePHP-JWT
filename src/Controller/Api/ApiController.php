<?php
namespace App\Controller\Api;

use Cake\Event\Event;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\Http\ServerRequest;
use Cake\I18n\Time;

class ApiController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Users');

        $this->Auth->allow(['login', 'add']);

    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event); 
    }

    /**
     * Login User to generate token
     */
    public function login()
    {
        $user = $this->Auth->identify();

        if (!$user) {
            throw new UnauthorizedException("Invalid login details");
        }else{
            $tokenId  = base64_encode(32);
            $issuedAt = time();
            $key = Security::salt();
            $this->set([
                'msg' => 'Login successfully',
                'success' => true,
                'user' => $user,
                'data' => [
                    'token' => JWT::encode([
                        'alg' => 'HS256',
                        'id' => $user['id'],
                        'sub' => $user['id'],
                        'iat' => time(),
                        'exp' =>  time() + 86400,
                    ],
                    $key)
                ],
                '_serialize' => ['success', 'data', 'user', 'key']
            ]);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups'],'order' => ['id' => 'desc']
        ];
        $users = $this->paginate($this->Users);
        
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }
	

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Groups', 'Addresses']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user', 'groups']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['group_id'] = 1;
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $msg['msg'] = 'The user has been saved.';
                $msg['status'] = 1;
            } else {
                $msg['msg'] = 'The user could not be saved. Please, try again.';
                $msg['status'] = 0;
                $msg['error'] = $user->getErrors();
            }
        }

        extract($msg);
        $this->set(compact('error', 'status', 'msg'));
        $this->set('_serialize', ['error', 'status', 'msg']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['group_id'] = 1;
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $msg['msg'] = 'The user has been saved.';
                $msg['status'] = 1;
            } else {
                $msg['msg'] = 'The user could not be saved. Please, try again.';
                $msg['status'] = 0;
                $msg['error'] = $user->getErrors();
            }
        }

        extract($msg);
        $this->set(compact('error', 'status', 'msg'));
        $this->set('_serialize', ['error', 'status', 'msg']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $msg['status'] = 1;
            $msg['msg'] = 'The user has been deleted.';
        } else {
            $msg['status'] = 0;
            $msg = 'The user could not be deleted. Please, try again.';
        }

        extract($msg);
        $this->set(compact('status', 'msg'));
        $this->set('_serialize', ['status', 'msg']);
    }
}