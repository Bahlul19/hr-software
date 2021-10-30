<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\ApprovedCompoff;
use Cake\Mailer\Email;

/**
 * CompOff Controller
 *
 * @property \App\Model\Table\CompOffTable $CompOff
 *
 * @method \App\Model\Entity\CompOff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

/**
 * ApprovedCompoff
 *
 * @property \App\Model\Table\ApprovedCompoffTable $ApprovedCompoff
 *
 * @method \App\Model\Entity\ApprovedCompoff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class CompOffController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('Employees');
        $branch = "";
        $keyword = "";
        $compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']]);
        $compOff = $this->paginate($compOff);

        if (!empty($this->request->getQuery('keyword'))) {
            $keyword = $this->request->getQuery('keyword');

            $compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']])->where(['employee_id'=>$keyword]);
            $compOff = $this->paginate($compOff);
        }

        $loggedInUserId = $this->Auth->user('id');

        //$compOffApprovedSum = $this->CompOff->find('all')->where(['employee_id'=>$loggedInUserId, 'status'=>1])->sumOf('number_of_hours');

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $loggedInUserId]])->first();

        if($approvedCompoff == null) {
            $compOffApprovedSum = 0;
        }
        else
            $compOffApprovedSum = $approvedCompoff->approved_hour;

        //$compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']]);

        //$compOff = $this->paginate($compOff);

        $loggedUserRole = $this->Auth->user('role_id');
        $is_manager = $this->Auth->user('is_manager');

        // Adding employee
        $this->loadModel('Employees');
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        $this->set(compact('compOff', 'branch', 'keyword', 'employees', 'loggedUserRole', 'compOffApprovedSum', 'is_manager', 'loggedInUserId'));
    }

    /**
     * View method
     *
     * @param string|null $id Comp Off id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $compOff = $this->CompOff->get($id, [
            'contain' => []
        ]);

        $compOffEmployeeId = $compOff->employee_id;

        //$compOffApprovedSum = $this->CompOff->find('all')->where(['employee_id'=>$compOffEmployeeId, 'status'=>1])->sumOf('number_of_hours');

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $compOffEmployeeId]])->first();

        if($approvedCompoff == null) {
            $compOffApprovedSum = 0;
        }
        else
            $compOffApprovedSum = $approvedCompoff->approved_hour;

        $this->set('compOff', $compOff);
        $this->set('compOffApprovedSum', $compOffApprovedSum);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

        $this->loadModel('Employees');
        $employeeId = $this->Auth->user('id');
        $loggedInEmployee = $this->Employees->get($employeeId);

        $employeeReportingManager = $this->CompOff->reportingManagerEmail($loggedInEmployee->reporting_manager);

        $employeeType = $loggedInEmployee->employment_type;

        $employeeOfficeLocation = $loggedInEmployee->office_location;

        $employeeRoleId = $loggedInEmployee->role_id;
        $is_manager = $this->Auth->user('is_manager');

        // Adding employee
        $employeeListPMName = $this->Employees->find('all')->WHERE(['is_pm' => 1])->toArray();
        $employees =  array();
        foreach($employeeListPMName as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        $nowDate = date('Y-m-d');
        $compOff = $this->CompOff->newEntity();
        if ($this->request->is('post')) {
            $compOffGetData = $this->request->getData();
            $compOffGetData['date'] = date('Y-m-d', strtotime($this->request->getData(['date'])));

            if ($nowDate ==  $compOffGetData['date'] || $nowDate >= $compOffGetData['date']) {
                $compOffEmployeeId = $compOffGetData['employee_id'];
                $compOffProjectManagerId = $compOffGetData['pm_id'];

                $appliedUsersEmail = $this->Auth->user('office_email');
                $compOffEmployeeOfficeEmail = $this->CompOff->employeeOfficeEmail($compOffEmployeeId);
                $name = $this->CompOff->employeeNameFromId($compOffEmployeeId);

                $pm_name = $this->CompOff->employeeNameFromId($compOffProjectManagerId);
                $date = $compOffGetData['date'];

                $compOffGetData['name'] = $name;
                $compOffGetData['pm_name'] = $pm_name;
                $compOffGetData['number_of_hours']= (float)$this->request->getData("number_of_hours");
                $compOff = $this->CompOff->patchEntity($compOff, $compOffGetData);
                if ($this->CompOff->save($compOff)) {
                    $emailTo = array();
                    $emailTo[] = 'hr@managedcoder.com';
                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                    ->setto($emailTo)
                    ->setCc('managers@sjinnovation.com')
                    ->setemailFormat('html')
                    ->setTemplate('comoff_email_apply')
                    ->setsubject($name . ' requested for compoff' . rand(108512, 709651))
                    ->setViewVars(['applierName' => $employeeName,
                        'name' => $name,
                        'date' => $date,
                        'number_of_hours' => $compOffGetData['number_of_hours'],
                        'pm_name' => $pm_name,
                        'team_name' => $compOffGetData['team_name'],
                        'project_task_details' => $compOffGetData['project_task_details'],
                        'name_of_the_project' => $compOffGetData['name_of_the_project']])
                    ->send();

                    $this->Flash->success(__('The comp off request has been saved successfully'));

                    $loggedUserRole = $this->Auth->user('role_id');

                    if ($loggedUserRole != 4) {
                        return $this->redirect(['action' => 'index']);
                    } else {
                        return $this->redirect(['action' => 'add']);
                    }
                }else{
                    $this->Flash->error(__('Some error ocured while saving your compoff.'));
                }
            }else{
                $this->Flash->error(__('You cann"t only apply for future date , please check!'));
                return $this->redirect(['action' => 'add']);
            }
        }
        $this->set(compact('compOff', 'employees', 'employeeId', 'employeeName', 'employeeRoleId', 'is_manager'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Comp Off id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Employees');
        $this->loadModel('ApprovedCompoff');

        $compOff = $this->CompOff->get($id, [
            'contain' => []
        ]);

        $compOffEmployeeId = $compOff->employee_id;
        $compOffProjectManagerId = $compOff->pm_id;

        $loggedInUserId = $this->Auth->user('id');
        $loggedInEmployee = $this->Employees->get($this->Auth->user('id'));

        $employeeName = $loggedInEmployee->first_name." ".$loggedInEmployee->last_name;

        $employeeReportingManager = $this->CompOff->reportingManagerEmail($loggedInEmployee->reporting_manager);

        $employeeType = $loggedInEmployee->employment_type;

        $employeeOfficeLocation = $loggedInEmployee->office_location;

        $employeeRoleId = $loggedInEmployee->role_id;

        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $compOffGetData = $this->request->getData();
            $compOffGetData['date'] = date('Y-m-d', strtotime($this->request->getData(['date'])));
            $compOffEmployeeId = $compOffGetData['employee_id'];
            $compOffProjectManagerId = $compOffGetData['pm_id'];

            $appliedUsersEmail = $this->Auth->user('office_email');
            $compOffEmployeeOfficeEmail = $this->CompOff->employeeOfficeEmail($compOffEmployeeId);
            $name = $this->CompOff->employeeNameFromId($compOffEmployeeId);
            $pm_name = $this->CompOff->employeeNameFromId($compOffProjectManagerId);

            $date = $compOffGetData['date'];

            $compOffGetData['name'] = $name;
            $compOffGetData['pm_name'] = $pm_name;

            $previous_number_of_hours = $compOff->number_of_hours;

            $compOff = $this->CompOff->patchEntity($compOff, $compOffGetData);

            if ($this->CompOff->save($compOff)) {

                if($compOff->status == 1) {
                    $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $compOffEmployeeId]])->first();
                    $approvedCompoff->approved_hour -= $previous_number_of_hours;
                    $approvedCompoff->approved_hour += $compOff->number_of_hours;
                    $this->ApprovedCompoff->save(($approvedCompoff));
                }

                $this->Flash->success(__('The comp off has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comp off could not be saved. Please, try again.'));
        }
        $this->set(compact('compOff', 'employees', 'loggedInUserId', 'compOffEmployeeId', 'compOffProjectManagerId', 'employeeRoleId'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Comp Off id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $compOff = $this->CompOff->get($id);

        $employee_id = $compOff->employee_id;
        $employee_office_email = $this->CompOff->employeeOfficeEmail($employee_id);

        if ($this->CompOff->delete($compOff)) {
            $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
            $name = $compOff->name;
            $date = $compOff->date;
            $number_of_hours = $compOff->number_of_hours;
            $pm_name = $compOff->pm_name;
            $team_name = $compOff->team_name;
            $project_task_details = $compOff->project_task_details;
            $name_of_the_project = $compOff->name_of_the_project;

            $emailTo = array();
            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                ->setto($emailTo)
                ->setCc('managers@sjinnovation.com')
                ->setemailFormat('html')
                ->setTemplate('comoff_email_delete')
                ->setsubject($applierName . ' deleted compoff request of '.$compOff->name . rand(108512, 709651))
                ->setViewVars(['applierName' => $applierName,
                    'name' => $name,
                    'date' => $date,
                    'number_of_hours' => $number_of_hours,
                    'pm_name' => $pm_name,
                    'team_name' => $team_name,
                    'project_task_details' => $project_task_details,
                    'name_of_the_project' => $name_of_the_project])
                ->send();
            $this->Flash->success(__('The comp off has been deleted.'));
        } else {
            $this->Flash->error(__('The comp off could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //Comoff Approved Method

    public function comOffApproved($id = null)
    {
        $employeeId = $this->Auth->user('id');
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

        $this->loadModel('Employees');
        $this->loadModel('ApprovedCompoff');
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,4);
        if(in_array($loggedUser, $role))
        {
            $approveComOffRequest = $this->CompOff->get($id);
            $name = $approveComOffRequest->name;
            $employee_id = $approveComOffRequest->employee_id;
            $date = $approveComOffRequest->date;
            $number_of_hours = $approveComOffRequest->number_of_hours;
            $pm_name = $approveComOffRequest->pm_name;
            $team_name = $approveComOffRequest->team_name;
            $project_task_details = $approveComOffRequest->project_task_details;
            $name_of_the_project = $approveComOffRequest->name_of_the_project;
            $approveComOffRequest->status = 1;
            $comOffID = $approveComOffRequest->id;

            if($this->CompOff->save($approveComOffRequest))
            {
                $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $employee_id]])->first();

                if($approvedCompoff == null) {
                    $data=[
                        'employee_id' => $employee_id,
                        'employee_name' => $name,
                        'approved_hour' => (float)$number_of_hours
                    ];
                    $approvedCompoff =$this->ApprovedCompoff->newEntity($data);
                    if($this->ApprovedCompoff->save($approvedCompoff)) {
                        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $employee_id]])->first();
                    }
                }

                else {
                    $approvedCompoff->approved_hour += $number_of_hours;
                    $this->ApprovedCompoff->save(($approvedCompoff));
                }

                $applierEmail = $this->Auth->user('office_email');
                $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

                $emailTo = array();
                $email = new Email();
                $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                    ->setto($emailTo)
                    ->setCc('managers@sjinnovation.com')
                    ->setemailFormat('html')
                    ->setTemplate('comoff_email_approved')
                    ->setsubject($applierName . ' approved for compoff request' . rand(108512, 709651))
                    ->setViewVars(['applierName' => $applierName,
                        'name' => $name,
                        'date' => $date,
                        'number_of_hours' => $number_of_hours,
                        'pm_name' => $pm_name,
                        'team_name' => $team_name,
                        'project_task_details' => $project_task_details,
                        'name_of_the_project' => $name_of_the_project])
                    ->send();

                $this->Flash->success(__('The comp off request have been accepted.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('This request could not be accepted.'));
            }
        }
        else
        {
            return $this->redirect(['action' => 'index']);
        }
    }

    //Comoff Rejected Method

    public function comOffRejected($id = null)
    {
        $employeeId = $this->Auth->user('id');
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');
        $loggedUser = $this->Auth->user('role_id');
        $loggedUserId = $this->Auth->user('id');

        $role = array(1,2,4);
        if(in_array($loggedUser, $role))
        {
            $approveComOffRequest = $this->CompOff->get($id);
            $name = $approveComOffRequest->name;
            $date = $approveComOffRequest->date;
            $number_of_hours = $approveComOffRequest->number_of_hours;
            $pm_name = $approveComOffRequest->pm_name;
            $team_name = $approveComOffRequest->team_name;
            $project_task_details = $approveComOffRequest->project_task_details;
            $name_of_the_project = $approveComOffRequest->name_of_the_project;

            if($loggedUserId != $approveComOffRequest->employee_id)
                $approveComOffRequest->status = 2;
            else
                $approveComOffRequest->status = 2;

            $comOffID = $approveComOffRequest->id;
            if($this->CompOff->save($approveComOffRequest))
            {
                $applierEmail = $this->Auth->user('office_email');
                $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

                $emailTo = array();
                $email = new Email();
                $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                    ->setto($emailTo)
                    ->setCc('managers@sjinnovation.com')
                    ->setemailFormat('html')
                    ->setTemplate('comoff_email_rejected')
                    ->setsubject($applierName . ' cancelled the comoff request of '.$name. rand(108512, 709651))
                    ->setViewVars(['applierName' => $applierName,
                        'name' => $name,
                        'date' => $date,
                        'number_of_hours' => $number_of_hours,
                        'pm_name' => $pm_name,
                        'team_name' => $team_name,
                        'project_task_details' => $project_task_details,
                        'name_of_the_project' => $name_of_the_project])
                    ->send();

                $this->Flash->success(__('The compoff request have been rejected.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('This request could not be cancelled '));
            }
        }
        else
        {
            return $this->redirect(['action' => 'index']);
        }
    }

    public function pending()
    {
        $this->loadModel('Employees');
        $branch = "";
        $keyword = "";
        $compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']])->where(['status'=>0]);
        $compOff = $this->paginate($compOff);

        if (!empty($this->request->getQuery('keyword'))) {
            $keyword = $this->request->getQuery('keyword');

            $compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']])->where(['employee_id'=>$keyword])->where(['status'=>0]);
            $compOff = $this->paginate($compOff);
        }

        $loggedInUserId = $this->Auth->user('id');

        //$compOffApprovedSum = $this->CompOff->find('all')->where(['employee_id'=>$loggedInUserId, 'status'=>1])->sumOf('number_of_hours');

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $loggedInUserId]])->first();

        if($approvedCompoff == null) {
            $compOffApprovedSum = 0;
        }
        else
            $compOffApprovedSum = $approvedCompoff->approved_hour;

        //$compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']]);

        //$compOff = $this->paginate($compOff);

        $loggedUserRole = $this->Auth->user('role_id');
        $is_manager = $this->Auth->user('is_manager');

        // Adding employee
        $this->loadModel('Employees');
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        $this->set(compact('compOff', 'branch', 'keyword', 'employees', 'loggedUserRole', 'compOffApprovedSum', 'is_manager', 'loggedInUserId'));
    }

    public function approved()
    {
        $this->loadModel('Employees');
        $branch = "";
        $keyword = "";
        $compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']])->where(['status'=>1]);
        $compOff = $this->paginate($compOff);

        if (!empty($this->request->getQuery('keyword'))) {
            $keyword = $this->request->getQuery('keyword');

            $compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']])->where(['employee_id'=>$keyword])->where(['status'=>1]);
            $compOff = $this->paginate($compOff);
        }

        $loggedInUserId = $this->Auth->user('id');

        //$compOffApprovedSum = $this->CompOff->find('all')->where(['employee_id'=>$loggedInUserId, 'status'=>1])->sumOf('number_of_hours');

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $loggedInUserId]])->first();

        if($approvedCompoff == null) {
            $compOffApprovedSum = 0;
        }
        else
            $compOffApprovedSum = $approvedCompoff->approved_hour;

        //$compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']]);

        //$compOff = $this->paginate($compOff);

        $loggedUserRole = $this->Auth->user('role_id');
        $is_manager = $this->Auth->user('is_manager');

        // Adding employee
        $this->loadModel('Employees');
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        $this->set(compact('compOff', 'branch', 'keyword', 'employees', 'loggedUserRole', 'compOffApprovedSum', 'is_manager', 'loggedInUserId'));
    }

    public function rejected()
    {
        $this->loadModel('Employees');
        $branch = "";
        $keyword = "";
        $compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']])->where(['status'=>2]);
        $compOff = $this->paginate($compOff);

        if (!empty($this->request->getQuery('keyword'))) {
            $keyword = $this->request->getQuery('keyword');

            $compOff = $this->CompOff->find('all', ['order' => ['id' => 'desc']])->where(['employee_id'=>$keyword])->where(['status'=>2]);
            $compOff = $this->paginate($compOff);
        }

        $loggedInUserId = $this->Auth->user('id');

        //$compOffApprovedSum = $this->CompOff->find('all')->where(['employee_id'=>$loggedInUserId, 'status'=>1])->sumOf('number_of_hours');

        $this->loadModel('ApprovedCompoff');
        $approvedCompoff = $this->ApprovedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $loggedInUserId]])->first();

        if($approvedCompoff == null) {
            $compOffApprovedSum = 0;
        }
        else
            $compOffApprovedSum = $approvedCompoff->approved_hour;

        $loggedUserRole = $this->Auth->user('role_id');
        $is_manager = $this->Auth->user('is_manager');

        // Adding employee
        $this->loadModel('Employees');
        $employeeList = $this->Employees->find('all');
        $employees =  array();
        foreach($employeeList as $EL){
            $Eid = $EL['id'];
            $EN = $EL['first_name'].' '.$EL['last_name'];
            $employees[$Eid] = $EN;
        }

        $this->set(compact('compOff', 'branch', 'keyword', 'employees', 'loggedUserRole', 'compOffApprovedSum', 'is_manager', 'loggedInUserId'));

    }
}
