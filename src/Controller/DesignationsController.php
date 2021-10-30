<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Designations Controller
 *
 * @property \App\Model\Table\DesignationsTable $Designations
 *
 * @method \App\Model\Entity\Designation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DesignationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $keyword="";
        $this->paginate = [
            'limit' =>15
        ];

         if (!empty($this->request->getQuery('search'))) {
            $keyword = $this->request->getQuery('search');
            $designations = $this->Designations->searchByTitleAndNoOfEmployeesAndStatus($keyword);
            $designations = $this->paginate($designations);

        }
        else{
             $designations = $this->paginate($this->Designations);
        }

        $branch = "";
        $this->set(compact('branch', 'designations', 'keyword'));
    }

    /**
     * View method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $designation = $this->Designations->get($id);
         $this->set('designation', $designation);
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
        $oldDesignations = $this->Designations->find();
        if (in_array($loggedUser, $role)) {
            $designationsTable = $this->Designations->find('list')->WHERE(['status'=>1]);
            $designationsList = $designationsTable->toArray();
            $designationsList[''] = 'Select Designation';

            $designation = $this->Designations->newEntity();
            if ($this->request->is('post')) {
                $designation = $this->Designations->patchEntity($designation, $this->request->getData());

                $designationKey = $this->request->getData(['hidden-designation-key']);

                $isDesignationExist = $this->Designations->find('all')->where(['id'=>$designationKey])->toArray();

                if($isDesignationExist == null) {
                    if ($this->Designations->save($designation)) {
                        $this->Flash->success(__('The designation has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    else {
                        $this->Flash->error(__('The designation could not be saved. Please, try again.'));
                        return $this->redirect(['action' => 'index']);
                    }
                }
                else {
                    $this->Flash->error(__('The designation already exists.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->set(compact('designation', 'designationsList', 'oldDesignations'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2);
        if (in_array($loggedUser, $role)) {
            $designation = $this->Designations->get($id, [
                'contain' => []
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $designation = $this->Designations->patchEntity($designation, $this->request->getData());
                if ($this->Designations->save($designation)) {
                    $this->Flash->success(__('The designation has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The designation could not be saved. Please, try again.'));
            }
            $this->set(compact('designation','status'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2);
        if (in_array($loggedUser, $role)) {
            $designation = $this->Designations->get($id);
            $designation->status = 0;
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('The designation has been deactivated.'));
            } else {
                $this->Flash->error(__('The designation could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }
}
