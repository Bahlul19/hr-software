<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DesignationChanges Controller
 *
 * @property \App\Model\Table\DesignationChangesTable $DesignationChanges
 *
 * @method \App\Model\Entity\DesignationChange[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DesignationChangesController extends AppController
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
        $designationChanges = $this->paginate($this->DesignationChanges);

        $this->set(compact('designationChanges'));
    }

    /**
     * View method
     *
     * @param string|null $id Designation Change id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $designationChange = $this->DesignationChanges->get($id, [
            'contain' => ['Employees']
        ]);

        $this->set('designationChange', $designationChange);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $designationChange = $this->DesignationChanges->newEntity();
        if ($this->request->is('post')) {
            $designationChange = $this->DesignationChanges->patchEntity($designationChange, $this->request->getData());
            if ($this->DesignationChanges->save($designationChange)) {
                $this->Flash->success(__('The designation change has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The designation change could not be saved. Please, try again.'));
        }
        $employees = $this->DesignationChanges->Employees->find('list', ['limit' => 200]);
        $this->set(compact('designationChange', 'employees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Designation Change id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $designationChange = $this->DesignationChanges->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $designationChange = $this->DesignationChanges->patchEntity($designationChange, $this->request->getData());
            if ($this->DesignationChanges->save($designationChange)) {
                $this->Flash->success(__('The designation change has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The designation change could not be saved. Please, try again.'));
        }
        $employees = $this->DesignationChanges->Employees->find('list', ['limit' => 200]);
        $this->set(compact('designationChange', 'employees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Designation Change id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $designationChange = $this->DesignationChanges->get($id);
        if ($this->DesignationChanges->delete($designationChange)) {
            $this->Flash->success(__('The designation change has been deleted.'));
        } else {
            $this->Flash->error(__('The designation change could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
