<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\ApprovedCompoff;
use Cake\Mailer\Email;

/**
 * UtilizeComoffs Controller
 *
 * @property \App\Model\Table\UtilizeComoffsTable $UtilizeComoffs
 *
 * @method \App\Model\Entity\UtilizeComoff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

/**
 * ApprovedCompoff
 *
 * @property \App\Model\Table\ApprovedCompoffTable $ApprovedCompoff
 *
 * @method \App\Model\Entity\ApprovedCompoff[]|\Cake\Datasource\ResultSetInterface paginate2($object = null, array $settings = [])
 */

/**
 * ApprovedCompoff
 *
 * @property \App\Model\Table\UtilizeComoffsTable $UtilizeComoffs
 *
 * @method \App\Model\Entity\ApprovedCompoff[]|\Cake\Datasource\ResultSetInterface paginate3($object = null, array $settings = [])
 */

class UtilizeComoffsController extends AppController
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

        $this->loadModel('Employees');
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        $keyword = "";
        $utilizeComoffs = $this->UtilizeComoffs->find('all', array('order'=>array('UtilizeComoffs.id'=>'desc')));
        $utilizeComoffs = $this->paginate($utilizeComoffs);

        if (!empty($this->request->getQuery('keyword'))) {
            $keyword = $this->request->getQuery('keyword');

            $utilizeComoffs = $this->UtilizeComoffs->find('all')->where(['employee_id'=>$keyword]);
            $utilizeComoffs = $this->paginate($utilizeComoffs);
        }

        //$utilizeComoffs = $this->paginate($this->UtilizeComoffs);
        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $is_manager = $this->Auth->user('is_manager');

        $branch = "";
        $this->set(compact('utilizeComoffs', 'branch', 'employees', 'employeeId', 'roleId', 'is_manager'));
    }

    /**
     * View method
     *
     * @param string|null $id Utilize Comoff id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $utilizeComoff = $this->UtilizeComoffs->get($id, [
            'contain' => ['Employees']
        ]);

        //$this->loadModel('CompOff');
        //$compOffApprovedSum = $this->CompOff->find('all')->where(['employee_id'=>$utilizeComoff->employee_id, 'status'=>1])->sumOf('number_of_hours');

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $utilizeComoff->employee_id]])->first();
        $compOffApprovedSum = $approvedCompoff->approved_hour;

        $this->set('utilizeComoff', $utilizeComoff);
        $this->set('compOffApprovedSum', $compOffApprovedSum);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Employees');
        $employeeId = $this->Auth->user('id');
        $employeeRoleId="";
        $is_manager="";
        $loggedInEmployee = $this->Employees->get($employeeId);

        $employeeName = $loggedInEmployee->first_name." ".$loggedInEmployee->last_name;

        $employeeRoleId = $loggedInEmployee->role_id;
        $is_manager = $this->Auth->user('is_manager');

        // Adding employee
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];

            $employees[$Eid] = $EN;
        }

        $nowDate = date('Y-m-d');

        $utilizeComoff = $this->UtilizeComoffs->newEntity();

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $employeeId]])->first();

        if($approvedCompoff!=null) {
            $approvedHour = $approvedCompoff->approved_hour;
        }else {
            $approvedHour = 0;
        }
        // if($approvedHour == null)

        if ($this->request->is('post')) {
            $utilizeCompOffGetData = $this->request->getData();
            $utilizeCompOffGetData['date'] = $utilizeCompOffGetData['dateFrom'];

            $utilizeCompOffGetData['date'] = date('Y-m-d', strtotime($utilizeCompOffGetData['date']));

            if(($this->Auth->user("role_id")==2) || $nowDate == $utilizeCompOffGetData['date'] || $nowDate < $utilizeCompOffGetData['date'])
            {
                $utilizeComoffEmployeeId = $utilizeCompOffGetData['employee_id'];
                $name = $this->UtilizeComoffs->employeeNameFromId($utilizeComoffEmployeeId);
                $utilizeCompOffGetData['employee_name'] = $name;
                $utilizeCompOffGetData['status'] = 0;
                $utilizeComoff = $this->UtilizeComoffs->patchEntity($utilizeComoff, $utilizeCompOffGetData);
                $this->loadModel('ApprovedCompoff');
                $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $utilizeComoffEmployeeId]])->first();
                if(isset($approvedCompoff->approved_hour)) {
                    $compOffApprovedSum = $approvedCompoff->approved_hour;
                }
                else {
                    $compOffApprovedSum = 0;
                }
    
                if($compOffApprovedSum == 0 || $compOffApprovedSum < $utilizeComoff->utilize_hours) {
                    $this->Flash->error(__("You don't have enough compoff approved hour. Your remaining compoff approved hour ".$compOffApprovedSum." hours" ));
                    return $this->redirect(['action' => 'index']);
                }
    
                else if ($this->UtilizeComoffs->save($utilizeComoff)) {
                    $emailTo = array();
                    $emailTo[] = 'hr@managedcoder.com';
    
                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto($emailTo)
                        ->setCc('managers@sjinnovation.com')
                        ->setemailFormat('html')
                        ->setTemplate('utilize_email_apply')
                        ->setsubject($utilizeComoff->employee_name . ' requested for utilizing his compoff' . rand(108512, 709651))
                        ->setViewVars(['applierName' => $employeeName,
                            'name' => $utilizeComoff->employee_name,
                            'date' => $utilizeComoff->date,
                            'number_of_hours' => $utilizeComoff->utilize_hours])
                        ->send();
    
                    $this->Flash->success(__('The utilize compoff request has been saved successfully.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            else {
                $this->Flash->error(__('Select future date for utilizing compoff, Please, try again.'));
                return $this->redirect(['action' => 'add']);
            }
        }
        $this->set(compact('utilizeComoff', 'employees', 'employeeId', 'employeeName', 'employeeRoleId', 'is_manager', 'approvedHour'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Utilize Comoff id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Employees');
        $employeeRoleId="";
        $is_manager="";
        $employeeName="";
        $loggedInUserEmployeeName = $this->Auth->user("first_name").$this->Auth->user("last_name");
        // Adding employee
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];

            $employees[$Eid] = $EN;
        }

        $utilizeComoff = $this->UtilizeComoffs->get($id, [
            'contain' => []
        ]);

        $employeeId = $utilizeComoff->employee_id;

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $employeeId]])->first();
        $approvedHour = $approvedCompoff->approved_hour;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $utilizeCompOffGetData = $this->request->getData();
            $utilizeCompOffGetData['date'] = date('Y-m-d', strtotime($this->request->getData(['date'])));
            $utilizeComoffEmployeeId = $utilizeCompOffGetData['employee_id'];
            $name = $this->UtilizeComoffs->employeeNameFromId($utilizeComoffEmployeeId);

            $utilizeCompOffGetData['employee_name'] = $name;

            if($utilizeComoff->status == 1) {
                $approvedCompoff->approved_hour += $utilizeComoff->utilize_hours;
            }

            $utilizeComoff = $this->UtilizeComoffs->patchEntity($utilizeComoff, $utilizeCompOffGetData);

            if($utilizeComoff->status == 1) {
                $approvedCompoff->approved_hour -= $utilizeComoff->utilize_hours;

                if($approvedCompoff->approved_hour < 0) {
                    $approvedCompoff->approved_hour += $utilizeComoff->utilize_hours;
                    $this->Flash->error(__($utilizeComoff->employee_name.' does not have enough approved compoff request. His remaining compoff request approved hour is '.$approvedCompoff->approved_hour." hours"));
                    return $this->redirect(['action' => 'index']);
                }
                else {
                    $this->ApprovedCompoff->save($approvedCompoff);
                }
            }

            if ($this->UtilizeComoffs->save($utilizeComoff)) {
                $emailTo = array();
                $emailTo[] = 'hr@managedcoder.com';
                $email = new Email();
                $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                    ->setto($emailTo)
                    ->setCc('managers@sjinnovation.com')
                    ->setemailFormat('html')
                    ->setTemplate('utilize_email_edit')
                    ->setsubject($loggedInUserEmployeeName . ' updated request for utilizing compoff hours of '.$utilizeComoff->employee_name. rand(108512, 709651))
                    ->setViewVars(['applierName' => $loggedInUserEmployeeName,
                        'name' => $utilizeComoff->employee_name,
                        'date' => $utilizeComoff->date,
                        'number_of_hours' => $utilizeComoff->utilize_hours])
                    ->send();

                $this->Flash->success(__('The utilize compoff has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The utilize compoff request could not be updated. Please, try again.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('utilizeComoff', 'employees', 'employeeId', 'employeeName', 'employeeRoleId', 'is_manager', 'approvedHour'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Utilize Comoff id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $utilizeComoff = $this->UtilizeComoffs->get($id);

        $utilizeHours = $utilizeComoff->utilize_hours;

        $loggedInUserEmployeeName = $this->Auth->user("first_name").$this->Auth->user("last_name");

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $utilizeComoff->employee_id]])->first();

        if($utilizeComoff->status == 1) {
            $approvedCompoff->approved_hour += $utilizeHours;
            $this->ApprovedCompoff->save($approvedCompoff);
        }

        if ($this->UtilizeComoffs->delete($utilizeComoff)) {
            $emailTo = array();
            $emailTo[] = 'hr@managedcoder.com';

            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                ->setto($emailTo)
                ->setCc('managers@sjinnovation.com')
                ->setemailFormat('html')
                ->setTemplate('utilize_email_delete')
                ->setsubject($loggedInUserEmployeeName . ' deleted request for utilizing compoff hours of '.$utilizeComoff->employee_name. rand(108512, 709651))
                ->setViewVars(['applierName' => $loggedInUserEmployeeName,
                    'name' => $utilizeComoff->employee_name,
                    'date' => $utilizeComoff->date,
                    'number_of_hours' => $utilizeComoff->utilize_hours])
                ->send();
            $this->Flash->success(__('The utilize compoff has been deleted.'));
        } else {
            $this->Flash->error(__('The utilize compoff could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function utilizeComOffApproved($id)
    {
        $utilizeComoff = $this->UtilizeComoffs->get($id, [
            'contain' => []
        ]);

        $loggedInUserName = $this->Auth->user('first_name')." ".$this->Auth->user('last_name');

        $utilizeComoff->status = 1;
        $utilizeComoff->approved_by = $loggedInUserName;

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $utilizeComoff->employee_id]])->first();

        if($approvedCompoff->approved_hour == 0 || $approvedCompoff->approved_hour < $utilizeComoff->utilize_hours ) {
            $this->Flash->error(__('The remaining compoff request is not sufficient.'));
            return $this->redirect(['action' => 'index']);
        }

        else {
            $approvedCompoff->approved_hour -= $utilizeComoff->utilize_hours;

            if ($this->UtilizeComoffs->save($utilizeComoff) && $this->ApprovedCompoff->save($approvedCompoff)) {
                $emailTo = array();
                $emailTo[] = 'hr@managedcoder.com';

                $email = new Email();
                $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                    ->setto($emailTo)
                    ->setCc('managers@sjinnovation.com')
                    ->setemailFormat('html')
                    ->setTemplate('utilize_email_approve')
                    ->setsubject($loggedInUserName . ' approved request for utilizing compoff hours of '.$utilizeComoff->employee_name. rand(108512, 709651))
                    ->setViewVars(['applierName' => $loggedInUserName,
                        'name' => $utilizeComoff->employee_name,
                        'date' => $utilizeComoff->date,
                        'number_of_hours' => $utilizeComoff->utilize_hours])
                    ->send();

                $this->Flash->success(__('The utilize compoff has been approved.'));
            }
            else {
                $this->Flash->error(__('The utilize compoff request could not be approved. Please, try again.'));
            }
            return $this->redirect(['action' => 'index']);
        }

    }

    public function utilizeComoffRequestCancellation($id)
    {
        $this->autoRender = false;

        $utilizeComoff = $this->UtilizeComoffs->get($id, [
            'contain' => []
        ]);

        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');

        if($employeeId != $utilizeComoff->employee_id) {
            $utilizeComoff->status = 2;
        }
        else {
            $utilizeComoff->status = 3;
        }

        $loggedInUserName = $this->Auth->user("first_name").$this->Auth->user("last_name");

        if ($this->UtilizeComoffs->save($utilizeComoff)) {
            $emailTo = array();
            $emailTo[] = 'hr@managedcoder.com';

            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                ->setto($emailTo)
                ->setCc('managers@sjinnovation.com')
                ->setemailFormat('html')
                ->setTemplate('utilize_email_cancel')
                ->setsubject($loggedInUserName . ' cancelled the request for utilizing compoff hours of '.$utilizeComoff->employee_name. rand(108512, 709651))
                ->setViewVars(['applierName' => $loggedInUserName,
                    'name' => $utilizeComoff->employee_name,
                    'date' => $utilizeComoff->date,
                    'number_of_hours' => $utilizeComoff->utilize_hours])
                ->send();
            $this->Flash->success(__('The utilize compoff has been cancelled.'));
            return $this->redirect(['action' => 'index']);
        }else {
            $this->Flash->error(__('The utilize compoff request could not be cancelled. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function pending() {
        $this->paginate = [
            'contain' => ['Employees']
        ];

        $this->loadModel('Employees');
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        $keyword = "";
        $utilizeComoffs = $this->UtilizeComoffs->find('all', array('order'=>array('UtilizeComoffs.id'=>'desc')))->where(['status'=>0]);
        $utilizeComoffs = $this->paginate($utilizeComoffs);

        if (!empty($this->request->getQuery('keyword'))) {
            $keyword = $this->request->getQuery('keyword');

            $utilizeComoffs = $this->UtilizeComoffs->find('all', array('order'=>array('UtilizeComoffs.id'=>'desc')))->where(['employee_id'=>$keyword])->where(['status'=>0]);
            $utilizeComoffs = $this->paginate($utilizeComoffs);
        }

        //$utilizeComoffs = $this->paginate($this->UtilizeComoffs);
        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $is_manager = $this->Auth->user('is_manager');

        $branch = "";
        $this->set(compact('utilizeComoffs', 'branch', 'employees', 'employeeId', 'roleId', 'is_manager'));
    }

    public function approved()
    {
        $this->paginate = [
            'contain' => ['Employees']
        ];

        $this->loadModel('Employees');
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        $keyword = "";
        $utilizeComoffs = $this->UtilizeComoffs->find('all', array('order'=>array('UtilizeComoffs.id'=>'desc')))->where(['status'=>1]);
        $utilizeComoffs = $this->paginate($utilizeComoffs);

        if (!empty($this->request->getQuery('keyword'))) {
            $keyword = $this->request->getQuery('keyword');

            $utilizeComoffs = $this->UtilizeComoffs->find('all', array('order'=>array('UtilizeComoffs.id'=>'desc')))->where(['employee_id'=>$keyword])->where(['status'=>1]);
            $utilizeComoffs = $this->paginate($utilizeComoffs);
        }

        //$utilizeComoffs = $this->paginate($this->UtilizeComoffs);
        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $is_manager = $this->Auth->user('is_manager');

        $branch = "";
        $this->set(compact('utilizeComoffs', 'branch', 'employees', 'employeeId', 'roleId', 'is_manager'));
    }

    public function rejected()
    {
        $this->paginate = [
            'contain' => ['Employees']
        ];

        $this->loadModel('Employees');
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        $keyword = "";
        $utilizeComoffs = $this->UtilizeComoffs->find('all', array('order'=>array('UtilizeComoffs.id'=>'desc')))->where(['status'=>2]);
        $utilizeComoffs = $this->paginate($utilizeComoffs);

        if (!empty($this->request->getQuery('keyword'))) {
            $keyword = $this->request->getQuery('keyword');

            $utilizeComoffs = $this->UtilizeComoffs->find('all', array('order'=>array('UtilizeComoffs.id'=>'desc')))->where(['employee_id'=>$keyword])->where(['status'=>2]);
            $utilizeComoffs = $this->paginate($utilizeComoffs);
        }

        //$utilizeComoffs = $this->paginate($this->UtilizeComoffs);
        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $is_manager = $this->Auth->user('is_manager');

        $branch = "";
        $this->set(compact('utilizeComoffs', 'branch', 'employees', 'employeeId', 'roleId', 'is_manager'));

    }

    public function getAvailableCompoffHours() {
        $employeeId = $this->request->getData(['empId']);
        $approvedHour = $this->UtilizeComoffs->getApprovedCompoffHourFromId($employeeId);
        $this->set(compact('approvedHour'));
    }

    public function getEmployeeCompoff($employeeId=null)
    {
        $this->autoRender=false;
        if($employeeId!==null) {
             $approvedHour = $this->UtilizeComoffs->getApprovedCompoffHourFromId($employeeId);
            $this->response->body(json_encode($approvedHour));
        } else{
            $this->response->body(json_encode(-1));
        }
        return $this->response;
    }
}
