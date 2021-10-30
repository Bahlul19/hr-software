<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Policies Controller
 *
 * @property \App\Model\Table\PoliciesTable $Policies
 *
 * @method \App\Model\Entity\Policy[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PoliciesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $role = $this->Auth->user('role_id');
        $userOffice = $this->Auth->user('office_location');
        $allOffice = "All-Offices";
        $keyword="";
        $this->paginate = [
            'limit' => 15
        ];
        if($role == 1 || $role == 2){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $policies = $this->Policies->policySearchResults($keyword);
                $policies = $this->paginate($policies);
            } else {
                $Policies = $this->Policies->find()->WHERE(['is_approved' => 1])->WHERE(['is_updated'=>0]);
                $policies = $this->paginate($Policies);
            }
        } else {
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $policies = $this->Policies->policySearchResults($keyword);
                $policies = $this->paginate($policies);
            } else {
                $Policies = $this->Policies->find()->WHERE(['is_approved' => 1])->WHERE(['is_updated'=>0])->WHERE(['OR'=>[['office'=>$userOffice],['office'=>$allOffice]]]);
                $policies = $this->paginate($Policies);
            }
        }
        $pendingNumber = $this->Policies->find()->WHERE(['is_approved' => 0])->WHERE(['is_updated' => 1])->count();
        $this->set(compact('policies', 'keyword','role','pendingNumber'));
    }

    /**
     * View method
     *
     * @param string|null $id Policy id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Auth->user('role_id');
        $userOffice = $this->Auth->user('office_location');
        $allOffice = "All-Offices";
        $role = $this->Auth->user('role_id');
        if ($role == 1 || $role == 2){
            $policy = $this->Policies->get($id, [
                'contain' => []
            ]);
        }
        else{
            $policy = $this->Policies->get($id, [
                'contain' => [],
                'conditions' => ['OR'=>[['office'=>$userOffice],['office'=>$allOffice]]]
            ]);
        }
        
        $this->set(compact('policy','role'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $role = $this->Auth->user('role_id');
        if ($role == 1 || $role == 2){
            $policy = $this->Policies->newEntity();
            if ($this->request->is('post')) {
                $policy['is_updated']=0;
                $policy['approved_by']=0;
                $policy = $this->Policies->patchEntity($policy, $this->request->getData());
                if ($this->Policies->save($policy)) {
                    $this->Flash->success(__('The policy has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The policy could not be saved. Please, try again.'));
            }
            $this->set(compact('policy','role'));
        }
        else{
            $this->Flash->error(__('Sorry! You donot have access to this page'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Policy id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {   
        $role = $this->Auth->user('role_id');
        if ($role == 1 || $role == 2){

            $policy = $this->Policies->get($id, [
                'contain' => []
            ]);
            $name  = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
            if ($this->request->is(['patch', 'post', 'put'])) {
                $PolicyData =  $this->request->getData();
                $PolicyData['updated_by'] = $name;
                $policy = $this->Policies->patchEntity($policy,$PolicyData);
                if ($this->Policies->save($policy)) {
                    $this->Flash->success(__('The policy has been updated.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The policy could not be saved. Please, try again.'));
            }
            $this->set(compact('policy','role'));
        }
        else{
            $this->Flash->error(__('Sorry! You donot have access to this page'));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Policy id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $policy = $this->Policies->get($id);
        if ($this->Policies->delete($policy)) {
            $this->Flash->success(__('The policy has been deleted.'));
        } else {
            $this->Flash->error(__('The policy could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function pending()
    {
        $role = $this->Auth->user('role_id');
        $policies = $this->paginate($this->Policies);
        $this->paginate = [
            'limit' => 15
        ];
        if (!empty($this->request->getQuery('search'))) {
            $keyword = $this->request->getQuery('search');
            $policies = $this->Policies->policySearchResults($keyword);
            $policies = $this->paginate($policies);
        } else {
            $Policies = $this->Policies->find()->WHERE(['is_approved' => 0]);
            $policies = $this->paginate($Policies);
        }

        $this->set(compact('policies', 'keyword','role'));
    }

    public function approve($id = null)
    {
        $name = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
       
        $policy = $this->Policies->get($id, [
            'contain' => []
        ]);

            $PolicyData['is_approved'] = 1;
            $PolicyData['is_updated']  =0;
            $PolicyData['approved_by'] = $name;
            $policy = $this->Policies->patchEntity($policy, $PolicyData);
            if ($this->Policies->save($policy)) {
                $this->Flash->success(__('The policy has been Approved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The policy could not be Approved. Please, try again.'));
        
    }

}
