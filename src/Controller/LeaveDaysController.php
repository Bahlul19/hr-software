<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LeaveDays Controller
 *
 * @property \App\Model\Table\LeaveDaysTable $LeaveDays
 *
 * @method \App\Model\Entity\LeaveDay[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeaveDaysController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees']
        ];
        $leaveDays = $this->paginate($this->LeaveDays);

        $this->set(compact('leaveDays'));
    }

    /**
     * View method
     *
     * @param string|null $id Leave Day id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leaveDay = $this->LeaveDays->get($id, [
            'contain' => ['Employees']
        ]);

        $this->set('leaveDay',$leaveDay);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($employeeId = null,$employeeName = null,$officeLocation = null)
    {
        $createdBy = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $leaveDay = $this->LeaveDays->newEntity();
        if ($this->request->is('post')) {
            $leaveDay = $this->LeaveDays->patchEntity($leaveDay, $this->request->getData());
            if ($this->LeaveDays->save($leaveDay)) {
                $this->Flash->success(__('The leave day has been saved.'));

                return $this->redirect(['controller'=>'employees','action' => 'index']);
            }
            $this->Flash->error(__('The leave day could not be saved. Please, try again.'));
        }
        $this->set(compact('leaveDay','employeeId','employeeName','officeLocation','createdBy'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Leave Day id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $employeeName = null,$officeLocation=null)
    {
        $updatedBy = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $leaveDay = $this->LeaveDays->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leaveDay = $this->LeaveDays->patchEntity($leaveDay, $this->request->getData());
            if ($this->LeaveDays->save($leaveDay)) {
                $this->Flash->success(__('The leave day has been saved.'));

                return $this->redirect(['controller'=>'employees','action' => 'index']);
            }
            $this->Flash->error(__('The leave day could not be saved. Please, try again.'));
        }
        $employees = $this->LeaveDays->Employees->find('list', ['limit' => 200]);
        $this->set(compact('leaveDay', 'employees','employeeName','officeLocation','updatedBy'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Leave Day id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leaveDay = $this->LeaveDays->get($id);
        if ($this->LeaveDays->delete($leaveDay)) {
            $this->Flash->success(__('The leave day has been deleted.'));
        } else {
            $this->Flash->error(__('The leave day could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
