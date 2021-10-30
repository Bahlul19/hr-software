<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Departments Controller
 *
 * @property \App\Model\Table\DepartmentsTable $Departments
 *
 * @method \App\Model\Entity\Department[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DepartmentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'limit' =>15
        ];
        if (!empty($this->request->getQuery('search'))) {
            $keyword = $this->request->getQuery('search');
            $departments = $this->Departments->searchByNameAndNoOfEmployeesAndLeadAndStatus($keyword);
            $departments = $this->paginate($departments);

        }
        else{
            $departments = $this->paginate($this->Departments);
        }

        $this->set(compact('departments'));
    }

    /**
     * View method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $department = $this->Departments->get($id);

        $this->set('department', $department);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2);
        if (in_array($loggedUser, $role)) {
            $department = $this->Departments->newEntity();
            if ($this->request->is('post')) {
                $department = $this->Departments->patchEntity($department, $this->request->getData());
                if ($this->Departments->save($department)) {
                    $this->Flash->success(__('The department has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The department could not be saved. Please, try again.'));
            }
            $this->set(compact('department'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $department = $this->Departments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $department = $this->Departments->patchEntity($department, $this->request->getData());
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
        }
        $this->set(compact('department'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $department = $this->Departments->get($id);
        $department->status = 0;
        if ($this->Departments->save($department)) {
            $this->Flash->success(__('The department has been Deactivated.'));
        } else {
            $this->Flash->error(__('The department could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

