<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;

/**
 * ProcessDocumentations Controller
 *
 * @property \App\Model\Table\ProcessDocumentationsTable $ProcessDocumentations
 *
 * @method \App\Model\Entity\ProcessDocumentation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProcessDocumentationsController extends AppController
{

    public $reviewMonths=-3;
    
    public function initialize(){
        
        parent::initialize();
        $this->loadModel("Employees"); 
        $this->loadModel("Roles");
        $this->loadModel("Locations");
        $this->loadModel("Departments");
        $this->loadModel("Tags");
        $this->loadModel("AssignProcesses");
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $this->_checkUserAccess();
        $departmentId=$this->Auth->user('department_id');
        $roleId=$this->Auth->user('role_id');
        $officeLocation=$this->Auth->user('office_location');
        $allTags=[];
        $roles=[];
        $rolesData=$this->Roles->find("all")->toArray();
        $roles=[];
        $departments=[];
        foreach($rolesData as $key => $role) {
            $roles[$role['id']]=$role['role'];
        }
        $LocationsData=$this->Locations->find("all")->toArray();
        $Locations=[];
        foreach($LocationsData as $location){
            $Locations[$location['short']]=$location['locations'];
        } 
        $departments=$this->Departments->find("all")->toArray();
        foreach($departments as $department){
            $allDepartment[$department['id']]=str_replace('/',' & ',$department['name']);
        }
        $tagData=$this->Tags->find('all');
        foreach($tagData as $tag){
            $allTags[$tag['id']]=$tag['name'];
        }
        $search=$this->request->getQuery('searchTags');
        if($search!=null){
            $searchTags['tags like']='%,'.$search.',%';
        }else{
            $searchTags="";
        }
        if($this->request->getQuery('direction') && $this->request->getQuery('sort')){
            $sort['ProcessDocumentations.'.$this->request->getQuery('sort')]=$this->request->getQuery('direction');
        }else{
            $sort['ProcessDocumentations.created']='DESC';
        }

        if($roleId<4) { 
            $result = $this->ProcessDocumentations ->find('all')
                                                   ->select($this->ProcessDocumentations)
                                                   ->select($this->Employees)
                                                   ->select(function (\Cake\ORM\Query $query) {
                                                    return ['months' => $query->newExpr('TIMESTAMPDIFF(MONTH,NOW(),ProcessDocumentations.modified)')]; })
                                                   //->select(['months'=>'TIMESTAMPDIFF(MONTH,"'.date('Y-m-d h:i:s').'",ProcessDocumentations.modified)'])
                                                   ->contain('Employees')
                                                   ->having(['months >'=>$this->reviewMonths])
                                                   ->order($sort)
                                                   ->where($searchTags);
        }else{
            $result = $this->ProcessDocumentations->find("all")
                                                          ->select($this->ProcessDocumentations)
                                                          ->select($this->Employees)
                                                          ->select(function (\Cake\ORM\Query $query) {
                                                            return ['months' => $query->newExpr('TIMESTAMPDIFF(MONTH,NOW(),ProcessDocumentations.modified)')]; })
                                                         // ->select(['months'=>'TIMESTAMPDIFF(MONTH,"'.date('Y-m-d h:i:s').'",ProcessDocumentations.modified)'])
                                                          ->where(['roles like'=>'%,'.$departmentId.',%','office like'=>'%'.$officeLocation.'%'])
                                                          ->contain('Employees')
                                                          ->having(['months >'=>$this->reviewMonths])
                                                          ->order($sort)
                                                          ->where($searchTags);    
    }
    $processDocumentations=$this->paginate($result);
    $this->set(compact('processDocumentations','roles','Locations','allDepartment','roleId','allTags'));
}


    /**
     * View method
     *
     * @param string|null $id Process Documentation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->_checkUserAccess();
        $exist=$this->_checkIfProcessExist($id);
        if(!$exist){
                $processDocumentation = $this->ProcessDocumentations->get($id, [ 'contain' => []]);
                $roles=[];
                $locations;
                $Locations=[]; 
                $allDepartment=[];
                $locations;
                $role;
                
                $roleId=$this->Auth->user("role_id");
                $updatedStr = trim($processDocumentation['roles'],",");
                $param=explode(",",$updatedStr); 
                $rolesData=$this->Roles->find("all")->where(['id in'=>$param])->toArray();
            
                foreach($rolesData as $key => $role) {
                    $roles[$key]=$role['role'];
                }

                $updatedStr = trim($processDocumentation['office'],",");
                $param=explode(",",$updatedStr);
                $LocationsData=$this->Locations->find("all")->where(['short in'=>$param])->toArray();
        
                foreach($LocationsData as $location){
                    $Locations[$location['short']]=$location['locations'];
                } 
                
                $departments=$this->Departments->find("all")->toArray();
                foreach($departments as $department){
                    $allDepartment[$department['id']]=$department['name'];
                }

                if(!empty($Locations)){
                    $locations=implode(",",$Locations);
                }
                if(!empty($roles)){
                    $role=implode(",",$roles);
                }

                if(!empty($allDepartment)){
                    $departments=implode(",",$allDepartment);
                }

                $this->set(compact('processDocumentation','locations','role','roleId','departments'));  
        }else{
            $this->Flash->error(__('The process does not exist.'));
            return $this->redirect(['controller' => 'processDocumentations', 'action' => 'index']); 
        }
       
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->_checkUserAccess();
        
        $roles=[];
        $Locations=[];
        $allDepartment=[];
        $allTags=[];

        $allDepartment[0]="All Departemnts";
        $Locations['all']="All Locations";

        $departments=$this->Departments->find("all")->toArray();
        
        $roleId=$this->Auth->user("role_id");
        
        $userId=$this->Auth->user("id");

        if($userId==4) {
            return $this->redirect(['controller' => 'processDocumentations', 'action' => 'index']);
        }

        $rolesData=$this->Roles->find("all")->toArray();
        $locationsData=$this->Locations->find("all")->toArray();
        $departments=$this->Departments->find("all")->toArray();
        $tags=$this->Tags->find("all")->toArray();
       
        foreach($rolesData as $role){
            $roles[$role['id']]=$role['role'];
        }

        foreach($locationsData as $location){
            $Locations[$location['short']]=$location['locations'];
        }

        foreach($departments as $department){
           
            $allDepartment[$department['id']]= str_replace('/',' & ',$department['name']);
        }
        foreach($tags as $tag){
            $allTags[$tag['id']]=$tag['name'];
        }

        $processDocumentation = $this->ProcessDocumentations->newEntity();
        if ($this->request->is('post')) {
            $data=$this->request->getData();
            if($data['roles'][0]==0){
                $allDepartment=array_keys($allDepartment);
                array_shift($allDepartment);
                $data['roles']=','.implode(",",$allDepartment).',';
            }else{
                 $data['roles']=','.implode(",",$data['roles']).',';
            } 
            
            if($data['office'][0]=="all"){ 
                $Locations=array_keys($Locations);
                array_shift($Locations);
                $data['office']=','.implode(",",$Locations).',';
            }else{
                $data['office']=','.implode(",",$data['office']).',';
            }

            $data['tags']=  (!empty($data['tags'])) ? ','.implode(",",$data['tags']).',':"";
            $data['last_updated_by']=$userId;
            $processDocumentation = $this->ProcessDocumentations->patchEntity($processDocumentation, $data);
            if ($this->ProcessDocumentations->save($processDocumentation)) {
                $this->Flash->success(__('The process documentation has been saved.'));
                return $this->redirect(['controller' => 'processDocumentations', 'action' => 'index']);
            }
            $this->Flash->error(__('The process documentation could not be saved. Please, try again.'));
        }
        $this->set(compact('processDocumentation','roles','Locations','allDepartment','allTags'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Process Documentation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {   
        
        $this->_checkUserAccess();
        $exist=$this->_checkIfProcessExist($id);
        if(!$exist){
                $userId=$this->Auth->user("id");
                if($userId==4) {
                    return $this->redirect(['controller' => 'processDocumentations', 'action' => 'index']);
                }

                $allTags=[];
                $this->loadModel("Tags");
                $tags=$this->Tags->find("all")->toArray();
                foreach($tags as $tag){
                    $allTags[$tag['id']]=$tag['name'];
                }

                $processDocumentation = $this->ProcessDocumentations->get($id, [
                    'contain' => []
                ]);

                $rolesData=$this->Roles->find("all")->toArray();
                $roles=[];
                foreach($rolesData as $role){
                    $roles[$role['id']]=$role['role'];
                }

                $LocationsData=$this->Locations->find("all")->toArray();
                $Locations['all']="All Locations";
                foreach($LocationsData as $location){
                    $Locations[$location['short']]=$location['locations'];
                }

                $allDepartment[0]="All Departemnts";
                $departments=$this->Departments->find("all")->toArray();
                foreach($departments as $department){
                    $allDepartment[$department['id']]=str_replace('/',' & ',$department['name']);
                }

                $allTags=[];
                $tags=$this->Tags->find("all")->toArray();
                foreach($tags as $tag){
                    $allTags[$tag['id']]=$tag['name'];
                }

                if ($this->request->is(['patch', 'post', 'put'])) {
                    $data=$this->request->getData();
                    
                    if($data['roles'][0]==0){
                        $allDepartment=array_keys($allDepartment);
                        array_shift($allDepartment);
                        $data['roles']=','.implode(",",$allDepartment).',';
                    }else{
                         $data['roles']=','.implode(",",$data['roles']).',';
                    } 
                    
                    if($data['office'][0]=="all"){ 
                        $Locations=array_keys($Locations);
                        array_shift($Locations);
                        $data['office']=','.implode(",",$Locations).',';
                    }else{
                        $data['office']=','.implode(",",$data['office']).',';
                    }
                    
                    $data['tags']=  (!empty($data['tags'])) ? ','.implode(",",$data['tags']).',':"";
                    
                    $data['last_updated_by']=$userId;
                    $processDocumentation = $this->ProcessDocumentations->patchEntity($processDocumentation,$data);
                    if ($this->ProcessDocumentations->save($processDocumentation)) {
                        $this->Flash->success(__('The process documentation has been saved.'));
                        return $this->redirect(['controller' => 'processDocumentations', 'action' => 'index']);
                    }
                    $this->Flash->error(__('The process documentation could not be saved. Please, try again.'));
                }
                $this->set(compact('processDocumentation','roles','Locations','allDepartment','allTags'));  
        }else{
            $this->Flash->error(__('The process does not exist.'));
            return $this->redirect(['controller' => 'processDocumentations', 'action' => 'index']); 
        }
       
    }

    /**
     * Delete method
     *
     * @param string|null $id Process Documentation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->_checkUserAccess();
        $exist=$this->_checkIfProcessExist($id);

        if(!$exist){
              if(empty($this->AssignProcesses->find('all')->where(['process_id'=>$id])->toArray()))
              {
                  $this->request->allowMethod(['post', 'delete']);
                  $processDocumentation = $this->ProcessDocumentations->get($id);
                  if ($this->ProcessDocumentations->delete($processDocumentation)) {
                      $this->Flash->success(__('The process documentation has been deleted.'));
                  } else {
                      $this->Flash->error(__('The process documentation could not be deleted. Please, try again.'));
                  }
              }else{
                $this->Flash->error(__('The process is assigned to employees and cannot be deleted. Please unassign the process to delete.'));
              }
               
        }
        return $this->redirect(['controller' => 'processDocumentations', 'action' => 'index']); 
    }

    public function review(){    
        $this->_checkUserAccess();
        $userId=$this->Auth->user("id");
        if($userId==4) {
            return $this->redirect(['controller' => 'processDocumentations', 'action' => 'index']);
        }
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
        $allDepartment=[];
        $departments=$this->Departments->find("all")->toArray();
        foreach($departments as $department){
            $allDepartment[$department['id']]=str_replace('/',' & ',$department['name']);
        }
        $allTags=[];
        $tags=$this->Tags->find("all")->toArray();
        foreach($tags as $tag){
            $allTags[$tag['id']]=$tag['name'];
        }
        $processDocumentations =$this->ProcessDocumentations
                                     ->find('all') 
                                     ->select(function (\Cake\ORM\Query $query) {
                                        return ['months' => $query->newExpr('TIMESTAMPDIFF(MONTH,NOW(),ProcessDocumentations.modified)')]; })
                                    //  ->select(['months'=>"TIMESTAMPDIFF(MONTH,NOW(),ProcessDocumentations.modified)"])
                                     ->select($this->ProcessDocumentations)
                                     ->contain('Employees')
                                     ->having(['months <='=>$this->reviewMonths]); 
        $processDocumentations = $this->paginate($processDocumentations); 
        $this->set(compact('processDocumentations','userId','roles','Locations','allDepartment','allTags'));
    }

    public function addTags(){
        $this->_checkUserAccess();
        $tags = $this->Tags->newEntity();
        $allTags=$this->Tags->find('all');
  
        if($this->request->is('post'))
        {
            if(!empty($this->request->data())) {
                $tags=$this->Tags->patchEntity($tags,$this->request->data());
                if ($this->Tags->save($tags)) {
                    $this->Flash->success(__('The tags has been saved.'));
                    return $this->redirect(['action' => 'add_tags']);
                }
            }else{
                $this->Flash->error(__('Please create tag to add.'));
            }
        }
        $this->set(compact('tags','allTags'));
    }

    public function editTags($id=null){
        if(!$this->_checkIfTagExist($id)){
            $this->_checkUserAccess();
            $tags = $this->Tags->get($id); 

            if($this->request->is('post')){
                $tags=$this->Tags->patchEntity($tags,$this->request->data());
                if ($this->Tags->save($tags)) {
                    $this->Flash->success(__('The tags has been updated.'));
                    return $this->redirect(['action' => 'add-tags']);
                }
            }
            $this->set(compact('tags'));
        }else{
            return $this->redirect(['action' => 'add-tags']); 
        }
    }

    public function deleteTags($id=null){
        if(!$this->_checkIfTagExist($id)){
                $this->_checkUserAccess();
                $this->request->allowMethod(['post', 'delete']);
                $tags = $this->Tags->get($id);
                if ($this->Tags->delete($tags)) {
                    $this->Flash->success(__('The tag has been deleted.'));
                } else {
                    $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
                }
                return $this->redirect(['action' => 'add-tags']);
        }else{
            return $this->redirect(['action' => 'add-tags']);
        }
    }

    private function _checkUserAccess(){
       $roleId=$this->Auth->user('role_id');
         if($roleId<4){  
                return true;
         }else{
            return $this->redirect(['action' => 'list-assign-processes']);
         }  
    }

    public function assignProcesses(){
        $this->_checkUserAccess();
        $AssignProcesses = $this->AssignProcesses->newEntity();
        $processDocumentation = $this->ProcessDocumentations->find('all');
        $employees=$this->Employees->find('all');
        $allProcesses=[];
        $allEmployees=[];
        foreach($processDocumentation as $process) {
            $allProcesses[$process['id']]=$process['title'];
        }

        $LocationsData=$this->Locations->find("all")->toArray();
        foreach($LocationsData as $location){
            $allOffices[$location['short']]=$location['locations'];
        }   
         if($this->request->is('post')) {
            $data=$this->request->data();
            $process_id=$data['process_id'];
            if($data['employee_id']!==""){ 
                $offices=$data['office'];
                if($process_id!=""){
                    $success=0;
                    foreach($process_id as $pid) {
                        $data['process_id']=$pid;
                        $data['status']='1';
                        
                        if($data['employee_id']==0){
                            $data['employee_id']=(int) 0 ;
                        }

                        $AssignProcesses = $this->AssignProcesses->newEntity($data);
                        
                        if($this->AssignProcesses->save($AssignProcesses)) {
                            $success++;
                        }else {
                             $this->Flash->error('Same error occured,processes were not assigned to the employee'); 
                             break;
                        }      
                    }     
                    if($success==count($process_id)) {
                        if($success==1){
                            $process="process";
                        } else{
                            $process="processes"; //Selected process has been assigned to the employee
                        }
                        $this->Flash->success('Selected '.$process.' has been assigned to the employee');
                        return $this->redirect(['action' => 'assign-processes']);
                    }   
                }else{
                    $this->Flash->error('Please select processes to assign to the employee.');
                } 
            }else{
                $this->Flash->error('Please select employee to assign processes.');
            }
        }
        $this->set(compact('AssignProcesses','allProcesses','allEmployees','allOffices'));
    }

    public function listAssignProcesses() {
        $allProcesses=[];
        $roleId=$this->Auth->user('role_id');
        $userId=$this->Auth->user('id');
        $allsearch=['1'=>'Assigned','2'=>'Ongoing','3'=>'Completed'];
        $search=[];
        $allProcesses=[];
        $allEmployees=[];
        $locations=$this->Locations->find('all');
        $allLocations=[];

        foreach( $locations as $key =>  $location){
            $allLocations[$location['short']]=$location['locations'];
        }

        $employees=$this->Employees->find('all');
        foreach($employees as $employee){
            $allEmployees[$employee['id']]=$employee['first_name']." ".$employee['last_name']." (".$employee['office_location'].")";
        }

        $departments=$this->Departments->find("all")->toArray();
        $allDepartment=[];
            foreach($departments as $department){
                $allDepartment[$department['id']]=str_replace('/',' & ',$department['name']);
            }

            if($this->request->getQuery()!=null){
                if($this->request->getQuery('search')!=""){
                    $search['status']=$this->request->getQuery('search');
                }
            
                if($this->request->getQuery('my_processes')!=""){
                    $search['employee_id']=$userId;
                }

                if($this->request->getQuery('employee')!=""){
                    $search['employee_id']=$this->request->getQuery('employee');
                }
        }
        if($roleId<4) {
            $AssignProcesses = $this->paginate($this->AssignProcesses
                                                    ->find('all')
                                                    ->contain(['Employees','ProcessDocumentations'])
                                                    ->where($search));
        }else{
            $AssignProcesses = $this->paginate($this->AssignProcesses
                                                    ->find("all")
                                                    ->contain(['Employees','ProcessDocumentations'])
                                                    ->where(['employee_id'=>$userId])
                                                    ->where($search));
        }
        $this->set(compact('AssignProcesses','allProcesses','allEmployees','allLocations','allDepartment','roleId','allsearch'));
    }


    public function viewAssignedProcess($id=null) {
        $exist=$this->_checkIfAssignProcessExist($id);
        if(!$exist){
             $userId=$this->Auth->user('id');
             $roleId=$this->Auth->user('role_id');
             $assignedProcesses = $this->AssignProcesses->get($id, [ 'contain' => ['ProcessDocumentations']]);
             $processDocumentation=$assignedProcesses->process_documentation;
             $status=[2=>'Ongoing',3=>'Completed'];
             if($this->request->is('post')) {
                 $data=$this->request->data(); 
                 $updateProcess = $this->AssignProcesses->get($data['id']);
                 $updateProcess= $this->AssignProcesses->patchEntity($updateProcess,$data);
                 if($this->AssignProcesses->save($updateProcess)){
                     $this->Flash->success(__('Process has been marked as '.$status[$data['status']].'.'));
                     return $this->redirect(['action' => 'list-assign-processes']);
                 }
             }   
             $this->set(compact('processDocumentation','assignedProcesses','status','roleId','userId')); 
        }else{
            $this->Flash->error(__('Assigned process does not exist.'));
            return $this->redirect(['action' => 'list-assign-processes']);
        }
       
    }

    public function deleteAssignedProcess($id=null) {
        $this->_checkUserAccess();
        $exist=$this->_checkIfAssignProcessExist($id);
        if(!$exist){
            $this->request->allowMethod(['post', 'delete']);
            $tags = $this->AssignProcesses->get($id);
            if ($this->AssignProcesses->delete($tags)) {
                $this->Flash->success(__('The Assigned Process has been deleted.'));
            } else {
                $this->Flash->error(__('The Process could not be deleted. Please, try again.'));
            }
            return $this->redirect(['action' => 'list-assign-processes']);
        }else{
            return $this->redirect(['controller' => 'processDocumentations', 'action' => 'index']);
        }
    }

    public function getAlreadyAssignedProcesses($id=null){
            $this->autoRender=false;
            $seletedOption=$this->request->data('selected');
            $employee=$this->request->data('employee');
            $result=$this->AssignProcesses->find('all')->where(['process_id in'=>$seletedOption,'employee_id'=>$employee]);
            return $this->response->withType("application/json")->withStringBody(json_encode($result));
    }

    public function getDepartmentProcesses(){
        $this->autoRender=false;
        $id=$this->request->data('employee_id');
        $office=$this->request->data('office'); 
        $employee=$this->Employees->find('all')->select(['department_id','office_location'])->where(['id'=>$id])->toArray();
        $response=[];   
         if(!empty($employee)){
            $department_id=$employee[0]->department_id;
            $office_location=$employee[0]->office_location;
         }
       if($department_id==null){
            $department_id=-1;
       }
      
       if($department_id!=-1){
            $processes=$this->ProcessDocumentations->find('all')
                            ->contain(['AssignProcesses'])
                            ->where(['roles like'=> "%,".$department_id.",%",'office like'=>"%,".$office_location.",%"]);  //
        }
       $finalResponse['status']=$department_id;
       $finalResponse['data']=$processes;
       return $this->response->withType("application/json")->withStringBody(json_encode($finalResponse));
    }


        public function getOfficeProcsss($office=null){    
                
            if($office=="all"){
                    $LocationsData=$this->Locations->find("all")->toArray();
                    foreach($LocationsData as $location){
                        $Locations[]=$location['short'];
                    }
                    $office=implode(",",$Locations).',';
            }
                $processes=$this->ProcessDocumentations->find('all')->where(['office like'=>"%,".$office."%"]); 
            //    dd($processes);
                $finalResponse['status']=1;
                $finalResponse['data']=$processes;
                return $this->response->withType("application/json")->withStringBody(json_encode($finalResponse));
        }

    private function _checkIfProcessExist($id){
        $result=$this->ProcessDocumentations->find('all')->where(['id'=>$id])->toArray();
        if(empty($result)){
            return true;
        }else{
            return false;
        }
    }
   
    private function _checkIfAssignProcessExist($id){
        if(empty($this->AssignProcesses->find('all')->where(['id'=>$id])->toArray())){
            return true;
        }else{
            return false;
        }
    }
    private function _checkIfTagExist($id){
        if(empty($this->Tags->find('all')->where(['id'=>$id])->toArray())){
            return true;
        }else{
            return false;
        }
    }

    public function getEmployeeFromOffice($office=null){ 
        $data=$this->Employees->find("all")->where(['office_location'=>$office]); 
        $allEmployees="<option >Select Employees</option>";
        foreach($data as $employee){
            $allEmployees.="<option value='".$employee['id']."'>".$employee['first_name']." ".$employee['last_name']."</option>";    
        }
       $finalResponse['status']=1;
       $finalResponse['data']=$allEmployees;
       return $this->response->withType("application/json")->withStringBody(json_encode($finalResponse));
    }
}


