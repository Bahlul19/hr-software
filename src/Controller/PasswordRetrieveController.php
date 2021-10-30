<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PasswordRetrieve Controller
 *
 * @property \App\Model\Table\PasswordRetrieveTable $PasswordRetrieve
 *
 * @method \App\Model\Entity\PasswordRetrieve[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PasswordRetrieveController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $passwordRetrieve = $this->paginate($this->PasswordRetrieve);

        $this->set(compact('passwordRetrieve'));
    }

    /**
     * View method
     *
     * @param string|null $id Password Retrieve id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $passwordRetrieve = $this->PasswordRetrieve->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('passwordRetrieve', $passwordRetrieve);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $passwordRetrieve = $this->PasswordRetrieve->newEntity();
        if ($this->request->is('post')) {
            $passwordRetrieve = $this->PasswordRetrieve->patchEntity($passwordRetrieve, $this->request->getData());
            if ($this->PasswordRetrieve->save($passwordRetrieve)) {
                $this->Flash->success(__('The password retrieve has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The password retrieve could not be saved. Please, try again.'));
        }
        $users = $this->PasswordRetrieve->Users->find('list', ['limit' => 200]);
        $this->set(compact('passwordRetrieve', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Password Retrieve id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $passwordRetrieve = $this->PasswordRetrieve->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $passwordRetrieve = $this->PasswordRetrieve->patchEntity($passwordRetrieve, $this->request->getData());
            if ($this->PasswordRetrieve->save($passwordRetrieve)) {
                $this->Flash->success(__('The password retrieve has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The password retrieve could not be saved. Please, try again.'));
        }
        $users = $this->PasswordRetrieve->Users->find('list', ['limit' => 200]);
        $this->set(compact('passwordRetrieve', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Password Retrieve id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $passwordRetrieve = $this->PasswordRetrieve->get($id);
        if ($this->PasswordRetrieve->delete($passwordRetrieve)) {
            $this->Flash->success(__('The password retrieve has been deleted.'));
        } else {
            $this->Flash->error(__('The password retrieve could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
