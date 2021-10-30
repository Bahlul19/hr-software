<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Forms Controller
 *
 * @property \App\Model\Table\FormsTable $Forms
 *
 * @method \App\Model\Entity\Form[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FormsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('FormFields');
        $this->loadModel('Roles');
        $this->loadModel('Employees');
        $this->loadModel('FormFeedbackFor');
        $this->loadModel('FormVisibility');
      
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if($this->Auth->user('role_id')==4){
            $this->redirect(['controller'=>'employees',"action"=>'dashboard']);
        }
        $id=$this->Auth->user("id");
        $role=$this->Auth->user("role_id");
        
        $forms=$this->Forms->find('all')->where(['created_by'=>$id]);
       
        $forms = $this->paginate($forms);
        $this->set(compact('forms'));
    }

    /**
     * View method
     *
     * @param string|null $id Form id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if($this->Auth->user('role_id')==4){
            $this->redirect(['controller'=>'employees',"action"=>'dashboard']);
        }
        $form = $this->Forms->get($id, [
            'contain' => ['FormFields', 'FormSubmissions']
        ]);

        $this->set('form', $form);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if($this->Auth->user('role_id')==4){
            $this->redirect(['controller'=>'employees',"action"=>'dashboard']);
        }
        $roles = $this->Roles->find('list');
        $employeeArr = $this->Employees->find('all');
        $employees = array();
        foreach($employeeArr as $employee){
            $employees[$employee['id']] = $employee['first_name'].' '.$employee['last_name'];
        }
        $form = $this->Forms->newEntity();
        if ($this->request->is('post')) {
            $formDetails['title'] = $this->request->getData()['title'];
            $formDetails['description'] = $this->request->getData()['description'];
            $formDetails['slug'] = $this->request->getData()['slug'];
            $formDetails['status'] = $this->request->getData()['status'];
            $formDetails['created_by'] = $this->Auth->user('id');
            $formDetails['access_roles'] = $this->request->getData()['access_roles'];
            $formDetails['feedback_for'] = $this->request->getData()['feedback_for'];
            $formFeedbackFor = $this->request->getData()['available_for'];
            $formDetails['available_from'] = $this->request->getData()['available_from'];
            $formDetails['available_to'] = $this->request->getData()['available_to'];
            $feedBackFor=[];   
            if(!empty($formDetails['access_roles'])){
                foreach($formDetails['access_roles'] as $key => $ar){
                    $feedBackFor[$key]['role_id']=$ar;
                    $feedBackFor[$key]['employee_id']="";     
                }
            }

            if(!empty($formDetails['feedback_for'])){
                foreach($formDetails['feedback_for'] as $key => $ar){ 
                    $feedBackFor[$key]['role_id']="";
                    $feedBackFor[$key]['employee_id']=$ar;     
                }
            }

            $feedBackRole=[];
           if(!empty($formFeedbackFor)){
               foreach($formFeedbackFor as $key => $feedbackRole){
                $feedBackRole[$key]['role_id']=$feedbackRole;
               }
           } 
           $formDetails['form_feedback_for']=$feedBackFor;
           $formDetails['form_visibility']=$feedBackRole;
           $form = $this->Forms->patchEntity($form,$formDetails,['associated' => ['FormFeedbackFor','FormVisibility']]);                   
           if ($this->Forms->save($form)) {
                $formFields = $this->FormFields->newEntity();
                $formFields->form_id = $form->id;
                $formFields->field_data = '';
                if ($this->FormFields->save($formFields)) {
                    $this->Flash->success(__('The form has been saved.'));
                    return $this->redirect(['action' => 'index']);
               }
            }
            $this->Flash->error(__('The form could not be saved. Please, try again.'));
        }
        $this->set(compact('form'));
        $this->set(compact('roles','employees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Form id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if($this->Auth->user('role_id')==4){
            $this->redirect(['controller'=>'employees',"action"=>'dashboard']);
        }
        $available_for=[];
        $feedback_for_employee=[];
        $feedback_for_role=[];

        if(!empty($this->Forms->find('all')->where(['id'=>$id])->toArray())){
                $form = $this->Forms->get($id, [
                    'contain' => ['FormFeedbackFor','FormVisibility']
                ]);
                    
                $savedFormFeedbackFor = $form['form_feedback_for'];
                $savedFormvisibility=$form['form_visibility'];
                foreach($form['form_visibility'] as $form_visibility){
                $available_for[]=$form_visibility['role_id'];
                }
                foreach($form['form_feedback_for'] as $feedbackfor){
                    if($feedbackfor['employee_id']!=null){
                        $feedback_for_employee[]=$feedbackfor['employee_id'];
                    }
                    if($feedbackfor['role_id']!=null){
                        $feedback_for_role[]=$feedbackfor['role_id'];
                    } 
                }
                if ($this->request->is(['patch', 'post', 'put'])) {
                
                    $formDetails['title'] = $this->request->getData()['title'];
                    $formDetails['description'] = $this->request->getData()['description'];
                    $formDetails['slug'] = $this->request->getData()['slug'];
                    $formDetails['status'] = $this->request->getData()['status'];
                    $formDetails['available_from'] = $this->request->getData()['available_from'];
                    $formDetails['available_to'] = $this->request->getData()['available_to'];
                    $formDetails['access_roles'] = $this->request->getData()['access_roles'];
                    $formDetails['feedback_for'] = $this->request->getData()['feedback_for'];
                    $formFeedbackFor = $this->request->getData()['available_for'];
                    $feedBackFor=[];   

                    if(!empty($formDetails['access_roles'])){
                        foreach($formDetails['access_roles'] as $key => $ar){
                        foreach($savedFormFeedbackFor as $savedRole){
                            if($savedRole['role_id']==$ar){
                                $feedBackFor[$key]['id']=$savedRole['id'];
                                break;
                            }
                            }
                            $feedBackFor[$key]['role_id']=$ar;
                            $feedBackFor[$key]['employee_id']="";     
                        }
                        if(!empty($savedFormFeedbackFor) && $savedFormFeedbackFor[0]['employee_id']!=null){
                            $this->FormFeedbackFor->deleteAll($savedFormFeedbackFor);
                        }
                    }

                    if(!empty($formDetails['feedback_for'])){
                        foreach($formDetails['feedback_for'] as $key => $ar){ 
                            foreach($savedFormFeedbackFor as $savedEmp){
                                if($savedEmp['employee_id']==$ar){
                                $feedBackFor[$key]['id']=$savedEmp['id'];
                                break;
                                }
                        }
                            $feedBackFor[$key]['role_id']="";
                            $feedBackFor[$key]['employee_id']=$ar;     
                        }
                        if(!empty($savedFormFeedbackFor) && $savedFormFeedbackFor[0]['role_id']!=null){
                            $this->FormFeedbackFor->deleteAll($savedFormFeedbackFor);
                        }
                    }
                $feedBackRole=[];
                if(!empty($formFeedbackFor)){
                    foreach($formFeedbackFor as $key => $feedbackRole){
                        foreach($savedFormvisibility as $visibility){
                            if($visibility['role_id']==$feedbackRole){
                                $feedBackRole[$key]['id']=$visibility['id'];
                            }
                        }   
                        $feedBackRole[$key]['role_id']=$feedbackRole;
                    }
                } 
                $formDetails['form_feedback_for']=$feedBackFor;
                $formDetails['form_visibility']=$feedBackRole;
                $form = $this->Forms->patchEntity($form, $formDetails,['associated' => ['FormFeedbackFor','FormVisibility']]);
                    if ($this->Forms->save($form)) {
                        $this->Flash->success(__('The form has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('The form could not be saved. Please, try again.'));
                }

                $this->loadModel('Roles');
                $roles = $this->Roles->find('list');
                $this->loadModel('Employees');
                $employeeArr = $this->Employees->find('all');
                $employees = array();
                foreach($employeeArr as $employee){
                    $employees[$employee['id']] = $employee['first_name'].' '.$employee['last_name'];
                }
                $this->set(compact('form'));
                $this->set(compact('roles','employees','available_for','feedback_for_employee','feedback_for_role'));
        }else{
          //  $this->Flash->errror("The record you are trying to access is not available/deleted");
            return $this->redirect(['action'=>'index']);
        }
    }
    /**
     * Delete method
     *
     * @param string|null $id Form id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if($this->Auth->user('role_id')==4){
            $this->redirect(['controller'=>'employees',"action"=>'dashboard']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $form = $this->Forms->get($id);
        if ($this->Forms->delete($form)) {
            $this->FormFields->deleteAll(['form_id' => $id]);
            $this->Flash->success(__('The form has been deleted.'));
        } else {
            $this->Flash->error(__('The form could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
 
    public function removeAvailableFor(){
         $role_id=$this->request->getData("role_id");
         $form=$this->request->getData("form");
         $role=$this->FormVisibility->find("all")->where(['form_id'=>$form,'role_id'=>$role_id])->first();
         if($this->FormVisibility->delete($role)){
            return $this->response->withType('application/json')->withStringBody(json_encode(['code' => '1','data'=>("Role deleted successfully")]));
          }else{
            return $this->response->withType('application/json')->withStringBody(json_encode(['code' => '1','data'=>("Some error occured")]));  
          }
    }

    public function removeFeedbackFor(){
        $role_id=$this->request->getData("role_id");
        $form=$this->request->getData("form");
        $result=$this->FormFeedbackFor->find("all")->where(['form_id'=>$form,'OR'=>['role_id'=>$role_id,'employee_id'=>$role_id]])->first();
        if($this->FormFeedbackFor->delete($result)){
            return $this->response->withType('application/json')->withStringBody(json_encode(['code' => '1','data'=>("Employee deleted successfully")]));
          }else{
            return $this->response->withType('application/json')->withStringBody(json_encode(['code' => '1','data'=>("Some error occured")]));  
          }
    }

    public function formView($id = null)
    {
        $this->loadModel("Forms");
        $this->loadModel('Employees');
        $passedArgs = $this->request->getParam('pass');
       
        $userid=$this->Auth->user("id");
        $formField = $this->Forms->find('all', ['contain' => ['FormFields','FormFeedbackFor'=>['Roles'=>['Employees'],'Employees']]])
            ->where(['slug'=>$passedArgs[0]])
            ->first();

       if($formField!=null){ 
                if(!empty($formField)){
                    $formField=$formField->toArray();
                }
                $employees = array();
                $roles=  array();
                $employeeArr = $formField['form_feedback_for'];
                foreach ($employeeArr as $employee) {
                if($employee['employee']!==null){
                    if($employee['employee_id']!=$userid){
                        $employees[$employee['employee_id']] = $employee['employee']['first_name'].' '.$employee['employee']['last_name']; 
                    }
                    
                }else{
                    $allEmployees=$employee['role']['employees'];
                    foreach($allEmployees as $key => $employee){
                        if($employee['id']!=$userid){
                            $employees[$employee['id']] = $employee['first_name'].' '.$employee['last_name']; 
                        }
                    } 
                }
                } 
                $this->set(compact('formField'));
                $this->set(compact('employees'));
            }else{
            return $this->redirect(['controller'=>'Employees','action'=>'dashboard']);
        }
    }
}


