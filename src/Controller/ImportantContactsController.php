<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ImportantContacts Controller
 *
 * @property \App\Model\Table\ImportantContactsTable $ImportantContacts
 *
 * @method \App\Model\Entity\ImportantContact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImportantContactsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $officeLocation=$this->Auth->user("office_location");
        $roleId=$this->Auth->user("role_id");
        
        if($roleId<4){
             $data=$this->ImportantContacts->find("all");
        }else{
             $data=$this->ImportantContacts->find("all")->where(['location like'=>"%".$officeLocation."%",'role like'=>'%'.$roleId.'%']);
        }
        $importantContacts = $this->paginate($data);
        $this->set(compact('importantContacts','roleId'));
    }

    /**
     * View method
     *
     * @param string|null $id Important Contact id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
       if($id!=null)
       {
        $this->loadModel("Roles");
        $this->loadModel("Locations");
        $locations=$this->Auth->user("office_location");
        $roleId=$this->Auth->user("role_id");
        $role="";
        if(!$this->ImportantContacts->find('all')->where(['id'=>$id])->isEmpty()) {
                $importantContact = $this->ImportantContacts->get($id, [
                    'contain' => []
                ]);
            
                $param=explode(",",$importantContact['role']); 
                $rolesData=$this->Roles->find("all")->where(['id in'=>$param])->toArray();
                $roles=[];
                $roleIds=[];
                foreach($rolesData as $key => $role) {
                    $roles[$key]=$role['role'];
                    $roleIds[]=$role['id'];
                }
                $param=explode(",",$importantContact['location']);
                $LocationsData=$this->Locations->find("all")->where(['short in'=>$param])->toArray();
                $Locations=[];
                $locationShort=[];
                foreach($LocationsData as $key=> $location) {
                    $Locations[$key]=$location['locations'];
                    $locationShort[]=$location['short'];
                }

                if($roleId==4){
                     if(!in_array($locations,$locationShort) || !in_array($roleId,$roleIds)){
                        return $this->redirect(['action' => 'index']);    
                     }
                }

                if(!empty($roles)){
                    $role=implode(",",$roles);
                }
                if(!empty($Locations)){
                    $locations=implode(",",$Locations);
                }
            }else{
                return $this->redirect(['action' => 'index']);
            } 
       }else{
            return $this->redirect(['action' => 'index']);
       }
       $this->set(compact('importantContact','importantContact','role','locations','roleId'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->loadModel("Roles");
        $this->loadModel("Locations");
        $rolesData=$this->Roles->find("all")->toArray();
        $roles=[];
        $roleId=$this->Auth->user("role_id");
        if($roleId<4)
        {
            foreach($rolesData as $role){
                $roles[$role['id']]=$role['role'];
            }

            $LocationsData=$this->Locations->find("all")->toArray();
            $Locations=[];
            foreach($LocationsData as $location){
                $Locations[$location['short']]=$location['locations'];
            }
            $importantContact = $this->ImportantContacts->newEntity();
            if ($this->request->is('post')) {

                $data=$this->request->getData();
                $data['role']=implode(",",$data['role']);
                $data['location']=implode(",",$data['location']);
                $importantContact = $this->ImportantContacts->patchEntity($importantContact, $data);
                if ($this->ImportantContacts->save($importantContact)) {
                    $this->Flash->success(__('The important contact has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The important contact could not be saved. Please, try again.'));
            }
            $this->set(compact('importantContact','roles','Locations'));
        }else{
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Important Contact id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if($id!=null)
        {
            $this->loadModel("Roles");
            $this->loadModel("Locations");
            $roleId=$this->Auth->user("role_id");
            if($roleId<4)
            {
                if(!$this->ImportantContacts->find('all')->where(['id'=>$id])->isEmpty())
                {
                        $importantContact = $this->ImportantContacts->get($id);
                        $rolesData=$this->Roles->find("all")->toArray();
                        $roles=[];
                        foreach($rolesData as $role){
                            $roles[$role['id']]=$role['role'];
                        }
                
                        $LocationsData=$this->Locations->find("all")->toArray();
                        $Locations=[];
                        foreach($LocationsData as $location){
                            $Locations[$location['short']]=$location['locations'];
                        }
                    
                    if ($this->request->is(['patch', 'post', 'put'])) {
                        $data=$this->request->getData();
                        $data['role']=implode(",",$data['role']);
                        $data['location']=implode(",",$data['location']);
                        $importantContact = $this->ImportantContacts->patchEntity($importantContact,$data);
                        if ($this->ImportantContacts->save($importantContact)) {
                            $this->Flash->success(__('The important contact has been saved.'));

                            return $this->redirect(['action' => 'index']);
                        }
                        $this->Flash->error(__('The important contact could not be saved. Please, try again.'));
                    }  
                    $this->set(compact('importantContact','roles','Locations'));
                }else{
                    $this->Flash->error("The contact you are searching does not exist");
                    return $this->redirect(['action' => 'index']);
                }
            }else {
                return $this->redirect(['action' => 'index']);
            }
        }else {
            return $this->redirect(['action' => 'index']);
        }
      
    }

    /**
     * Delete method
     *
     * @param string|null $id Important Contact id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $roleId=$this->Auth->user("role_id");
        if($roleId<4)
        {
            $this->request->allowMethod(['post', 'delete']);
            $importantContact = $this->ImportantContacts->get($id);
            if ($this->ImportantContacts->delete($importantContact)) {
                $this->Flash->success(__('The important contact has been deleted.'));
            } else {
                $this->Flash->error(__('The important contact could not be deleted. Please, try again.'));
            }
        }
            return $this->redirect(['action' => 'index']);
    }
}

