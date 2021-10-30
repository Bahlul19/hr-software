<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FormSubmissions Controller
 *
 * @property \App\Model\Table\FormSubmissionsTable $FormSubmissions
 *
 * @method \App\Model\Entity\FormSubmission[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FormSubmissionsController extends AppController
{
    public function initialize(){
        parent::initialize();
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('Employees');
        $employeeId = "";
        $id=$this->Auth->user("id");
        $myResponse=0;

        $this->paginate = [
            'contain' => ['Forms','EmployeesA','EmployeesB']
        ];
        $where=[];
        if($this->Auth->user("role_id")==4 || !empty($this->request->getQuery('show_my'))){
            $where['employee_id']=$this->Auth->user("id");
        }else{
            $where['Forms.created_by']=$id;
            $where['feedback_for !=']=$this->Auth->user("id"); 
        }
        if($this->Auth->user("role_id")!=4){ 
            $result=$this->FormSubmissions->find("all")->contain(['EmployeesA','EmployeesB','Forms'])->where($where);
        }else{
            $result=$this->FormSubmissions->find("all")->contain(['EmployeesA','EmployeesB','Forms'])->where($where);
        }
        $formSubmissions = $this->paginate($result);
        $keyword="";
        
        $employeeList = $this->Employees->find('all');
        $employeesList = array();
        foreach($employeeList as $employee){
            $employeesList[$employee['id']] = $employee['first_name'].' '.$employee['last_name'];
        }
        $employeeId=$this->Auth->user("id");
        $loggedUserRole = $this->Auth->user('role_id');
        if (!empty($this->request->getQuery('keyword'))) {
            $employeeId = $this->request->getQuery('keyword');
            $formSubmissions = $this->FormSubmissions->find('all', ['order' => ['FormSubmissions.id' => 'desc']])->contain(['EmployeesA','EmployeesB','Forms'])->where(['feedback_for'=> $employeeId]);
            $formSubmissions = $this->paginate($formSubmissions);
            $keyword=$this->request->getQuery('keyword');
        }else if(!empty($this->request->getQuery('my_response'))){ 
            $myResponse=1;
            $formSubmissions = $this->FormSubmissions->find('all', ['order' => ['FormSubmissions.id' => 'desc']])
                                                     ->contain(['EmployeesA','EmployeesB','Forms'])
                                                     ->where(['feedback_for'=> $employeeId,'is_visible'=>1]);
            $formSubmissions = $this->paginate($formSubmissions);
        }
        $this->set(compact('formSubmissions','loggedUserRole','keyword'));
        $this->set(compact('employeesList','myResponse'));
    }

    /**
     * View method
     *
     * @param string|null $id Form Submission id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if(!empty($this->FormSubmissions->find('all')->where(['id'=>$id])->toArray())){
        $formSubmission = $this->FormSubmissions->get($id, [
            'contain' => ['Forms','EmployeesA','EmployeesB']
        ]);
        $role=$this->Auth->user("role_id");

        $this->set('formSubmission', $formSubmission);
        $this->set(compact('role'));
      }else{
        //$this->Flash->errror("The record you are trying to access is not available/deleted");
        return $this->redirect(['controller'=>'FormSubmissions','action'=>'index']);
      } 
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $formSubmission = $this->FormSubmissions->newEntity();
        if ($this->request->is('post')) {
            $this->response->disableCache();
            $ajaxData = $this->request->getData();
            $ajaxData['submitted_data'] =  $ajaxData['form_submission_data'];
            $formSubmission['employee_id'] = $this->Auth->user('id');
            $formSubmission['form_id'] = $ajaxData['form_id'];
            $formSubmission['feedback_for']= (int) $ajaxData['feedback_for'];
            $ajaxData['is_visible']=0;
            $ajaxData['feedback_for']= (int) $ajaxData['feedback_for']; 
            $formSubmission = $this->FormSubmissions->patchEntity($formSubmission,$ajaxData); 
            if ($this->FormSubmissions->save($formSubmission)) {
                $message = "success";
                $this->response->body($message);
                return $this->response;
            } else {
               // dd($formSubmission->errors());
                $message = "Error";
                $this->response->body($message);
                return $this->response;
            }
        }
        $forms = $this->FormSubmissions->Forms->find('list', ['limit' => 200]);
        $employees = $this->FormSubmissions->Employees->find('list', ['limit' => 200]);
        $this->set(compact('formSubmission'));   //, 'forms', 'employees'
    }

    /**
     * Edit method
     *
     * @param string|null $id Form Submission id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!empty($this->FormSubmissions->find('all')->where(['id'=>$id])->toArray())){
            $formSubmission = $this->FormSubmissions->get($id, [
                'contain' => []
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $formSubmission = $this->FormSubmissions->patchEntity($formSubmission, $this->request->getData());
                if ($this->FormSubmissions->save($formSubmission)) {
                    $this->Flash->success(__('The form submission has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The form submission could not be saved. Please, try again.'));
            }
            $forms = $this->FormSubmissions->Forms->find('list', ['limit' => 200]);
            $employees = $this->FormSubmissions->Employees->find('list', ['limit' => 200]);
            $this->set(compact('formSubmission', 'forms', 'employees'));
        }else{
           // $this->Flash->errror("The record you are trying to access is not available/deleted");
            return $this->redirect(['controller'=>'FormSubmissions','action'=>'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Form Submission id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $formSubmission = $this->FormSubmissions->get($id);
        if ($this->FormSubmissions->delete($formSubmission)) {
            $this->Flash->success(__('The form submission has been deleted.'));
        } else {
            $this->Flash->error(__('The form submission could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function markFormResponse(){
          $data=$this->request->getData();
          $result=$this->FormSubmissions->get($data['response_id']);
          $result = $this->FormSubmissions->patchEntity($result,$data); 
          if($this->FormSubmissions->save($result)){
            if($data['is_visible']==1){
                $message="The Form response is now visible to employee to see";
            }  else{
                $message="The Form response is will not visible to employee to see";
            }
            return $this->response->withType('application/json')->withStringBody(json_encode(['code' => '1','data'=>$message]));
          }else{
            return $this->response->withType('application/json')->withStringBody(json_encode(['code' => '0','data'=>"error occured"]));
          }
    }
}
