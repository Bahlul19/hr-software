<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\I18n\Time;

/**
 * EmpLeaves Controller
 *
 * @property \App\Model\Table\EmpLeavesTable $EmpLeaves
 *
 * @method \App\Model\Entity\EmpLeave[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmpLeavesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('EmpLeaves');
        $this->loadModel('Employees');
        $this->paginate = [
            'contain' =>    ['Employees']
        ];

        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $reportingManagerId = $this->Auth->user('reporting_manager');
        $listForReportingManager = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['reporting_managerId' => $employeeId])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation'=> 0]);

        $keywordGroup = $this->request->getQuery('group');
        if($roleId == 2){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                   if($keywordGroup !=="" && $keywordGroup !==null) {
                    $LeaveRequestsAll = $this->EmpLeaves->find('all');
                    $LeaveRequests=$LeaveRequestsAll->select($this->EmpLeaves)->select($this->Employees)->select([
                                                    'max_date'=>$LeaveRequestsAll->func()->max('date_to'),
                                                    'min_date'=>$LeaveRequestsAll->func()->min('date_from'),
                                                    'number_of_days'=>$LeaveRequestsAll->func()->sum('no_of_days'),
                                                    'group_id'=>'group_concat(EmpLeaves.id)'
                                                    ])
                                                    ->contain('Employees')
                                                    ->order(['EmpLeaves.id' => 'desc'])
                                                    ->WHERE(['status' => 1])
                                                    ->WHERE(['emp_leave_cancellation'=> 0])
                                                    ->group(['DATE_FORMAT(EmpLeaves.created,"%Y-%m-%d %H:%i")','employee_id','leave_reason','leave_type']);

                }else {
                    $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation'=> 0]);
                }
                $leaveRequests = $this->paginate($LeaveRequests);

            }
        } elseif (!empty($listForReportingManager)){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['OR'=>['employee_id'=>$employeeId,'reporting_managerId'=>$employeeId]])->WHERE(['status'=>1])->WHERE(['emp_leave_cancellation'=> 0]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } else {

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['employee_id' => $employeeId ])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation'=> 0]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }
        //for search functionality code from the leave list
        $this->loadModel('Employees');
        $employees = $this->Employees->find('list', [
            'keyField' => 'first_name',
            'valueField' => function ($e) {
                return $e->first_name . ' ' . $e->last_name;
            },
            array(
                'order' => array('("first_name") ASC')
        )]
        );

//         $now = time(); // or your date as well
// $your_date = strtotime("2010-01-31");
// $datediff = $now - $your_date;

// echo round($datediff / (60 * 60 * 24));


        $employees = $employees->toArray();
        $employees[''] = 'Select Employee';
        $keywordSearch = $this->request->getQuery('keyword');
        if (!empty($keywordSearch)) 
        {
            $leaveRequests = $this->EmpLeaves->find()
            ->where(
            ['employee_name LIKE' => '%' .$keywordSearch. '%']
            );
            $default=$keywordSearch;
            $leaveRequests = $this->paginate($leaveRequests);
        }else 
        {
            $default="";
        }
        $branch = '';

        $this->set(compact('leaveRequests','roleId', 'branch','employees','default'));
    }

    /**
     * View method
     *
     * @param string|null $id Emp Leave id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $designationId="";
        $this->loadModel('EmpLeaves');
        $this->loadModel('Employees');
        $leaveRequestAll = $this->EmpLeaves->find('all');

        $leaveRequest=$leaveRequestAll->where(['EmpLeaves.id in '=>$id])
                                                ->contain('Employees')
                                                ->group(['leave_reason','date(EmpLeaves.created)','leave_type'])
                                                ->toList();
         
        $dateAndDays=$this->EmpLeaves->find()->select(['min_date'=>'min(date_from)','max_date'=>'max(date_to)','no_of_days'=>'sum(no_of_days)','ids'=>'group_concat(id)'])->where('EmpLeaves.id in ('.$id.')')->toList();
                
        $leaveRequest=$leaveRequest[0];
        $dateAndDays= $dateAndDays[0];
        $userName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $isReportingManager = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');

        $this->set(compact('leaveRequest','designationId','userName','isReportingManager','roleId','dateAndDays','id'));
    }

    public function LeaveForOthers()
    {
        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');
        $leaveRequest = $this->EmpLeaves->newEntity();

        if ($this->request->is('post')) {
            $LeaveRequestsForm = $this->request->getData();
            $selectedReliever = $LeaveRequestsForm['list'];
            $employees = $this->Employees->get($LeaveRequestsForm['employee_id']);
            $employeeWhoAppliedLeaveForOthers = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
            $LeaveTakenForOthersName = $employees->first_name.' '. $employees->last_name;
            $LeaveRequestsForm = $this->EmpLeaves->convertStringtoDateFormat($LeaveRequestsForm);
            $leaveRequest = $this->EmpLeaves->patchEntity($leaveRequest, $LeaveRequestsForm);
            $reportingManagerId = $employees->reporting_manager;
            $reportingManagerEmail = $this->EmpLeaves->reportingManagerEmail($reportingManagerId);
            $leaveRequest->no_of_days = $LeaveRequestsForm['no_of_days'];
            $leaveRequest->reporting_managerId = $reportingManagerId;
            $leaveRequest->employee_name = $employees->first_name . ' ' . $employees->last_name;
            $selectedReliever = $LeaveRequestsForm['list'];

            $cnt = 0;
            foreach ($selectedReliever as $r) {
                if($cnt == 0) {
                    $leaveRequest->reliever = ",".$r;
                    $leaveRequest->reliever_name = $this->EmpLeaves->getNameFromId($r);
                }
                else {
                    $leaveRequest->reliever .= ",".$r;
                    $leaveRequest->reliever_name .= ", ".$this->EmpLeaves->getNameFromId($r);
                }
                $cnt++;
            }
            if($leaveRequest->no_of_days === '1' || $leaveRequest->no_of_days === '0.5') {
                if ($this->EmpLeaves->save($leaveRequest)) {
                    $applierEmail = $this->Auth->user('office_email');
                    if($reportingManagerEmail != null) {
                        $emailTo = array();
                        $emailTo[] = $reportingManagerEmail;
                        $email = new Email();
                        $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                            ->setto($emailTo)
                            ->setemailFormat('html')
                            ->setTemplate('leave_for_others_email_template')
                            ->setsubject($employeeWhoAppliedLeaveForOthers . ' Applied for Leave  of '.$LeaveTakenForOthersName.' #' . rand(108512, 709651))
                            ->setViewVars([
                                'employeeWhoAppliedLeaveForOthers' => $employeeWhoAppliedLeaveForOthers,
                                'LeaveTakenForOthersName' => $LeaveTakenForOthersName,
                                'date_from' => $LeaveRequestsForm['date_from'],
                                'date_to' => $LeaveRequestsForm['date_to'],
                                'leave_reason' => $LeaveRequestsForm['leave_reason'],
                                'reliever_name' => $leaveRequest['reliever_name'],
                                'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                                'leaveId' => $leaveRequest->id,
                                'no_of_days' => $LeaveRequestsForm['no_of_days'],
                                'leave_type' => $this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                            ->send();
                    } else {
                        $emailTo = array();
                        $emailTo[] = $reportingManagerEmail;
                        $email = new Email();
                        $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                            // ->setto('hr@managedcoder.com')
                            ->setemailFormat('html')
                            ->setTemplate('leave_for_others_email_template')
                            ->setsubject($employeeWhoAppliedLeaveForOthers . ' Applied for Leave  of '.$LeaveTakenForOthersName.' #' . rand(108512, 709651))
                            ->setViewVars([
                                'employeeWhoAppliedLeaveForOthers' => $employeeWhoAppliedLeaveForOthers,
                                'LeaveTakenForOthersName' => $LeaveTakenForOthersName,
                                'date_from' => $LeaveRequestsForm['date_from'],
                                'date_to' => $LeaveRequestsForm['date_to'],
                                'leave_reason' => $LeaveRequestsForm['leave_reason'],
                                'reliever_name' => $leaveRequest['reliever_name'],
                                'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                                'leaveId' => $leaveRequest->id,
                                'no_of_days' => $LeaveRequestsForm['no_of_days'],
                                'leave_type' => $this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                            ->send();
                    }
                    $this->Flash->success(__('The leave request has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
            }else if($leaveRequest->no_of_days > 1 && $leaveRequest->no_of_days < 7) {
                for ($i = 0; $i < $leaveRequest->no_of_days; $i++) {
                    $day = $i . ' day';
                    $var = $this->EmpLeaves->newEntity();
                    if ($i == 0) {
                        $var->date_from = date('Y-m-d', strtotime($this->request->getData(['date_from'])));
                        $var->date_to = date('Y-m-d', strtotime($this->request->getData(['date_from'])));
                    } else {
                        $var->date_from = date('Y-m-d', strtotime($day, strtotime($this->request->getData(['date_from']))));
                        $var->date_to = date('Y-m-d', strtotime($day, strtotime($this->request->getData(['date_from']))));
                    }

                    $var->employee_id = $leaveRequest->employee_id;
                    $var->employee_name = $employees->first_name . ' ' . $employees->last_name;;
                    $var->reporting_managerId = $reportingManagerId;
                    $var->leave_type = $this->request->getData(['leave_type']);
                    $var->no_of_days = 1;
                    $var->half_day = $this->request->getData(['half_day']);
                    $var->leave_reason = $this->request->getData(['leave_reason']);
                    $var->reliever = $leaveRequest->reliever;
                    $var->reliever_name = $leaveRequest->reliever_name;
                    $valueSaved = $this->EmpLeaves->save($var);
                }

                if ($valueSaved) {
                    //newcode for sending email
                    $applierEmail = $this->Auth->user('office_email');
                    $applierName = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

                    if($reportingManagerEmail != null) {
                        $emailTo = array();
                        $emailTo[] = $reportingManagerEmail;

                        $email = new Email();
                        $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                            ->setto($emailTo)
                            ->setemailFormat('html')
                            ->setTemplate('leave_for_others_email_template')
                            ->setsubject($employeeWhoAppliedLeaveForOthers . ' Applied for Leave  of '.$LeaveTakenForOthersName.' #' . rand(108512, 709651))
                            ->setViewVars([
                                'employeeWhoAppliedLeaveForOthers' => $employeeWhoAppliedLeaveForOthers,
                                'LeaveTakenForOthersName' => $LeaveTakenForOthersName,
                                'date_from' => $LeaveRequestsForm['date_from'],
                                'date_to' => $LeaveRequestsForm['date_to'],
                                'leave_reason' => $LeaveRequestsForm['leave_reason'],
                                'reliever_name' => $leaveRequest['reliever_name'],
                                'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                                'leaveId' => $leaveRequest->id,
                                'no_of_days' => $LeaveRequestsForm['no_of_days'],
                                'leave_type' => $this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                            ->send();
                    } else {
                        $email = new Email();
                        $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                            ->setemailFormat('html')
                            ->setTemplate('leave_for_others_email_template')
                            ->setsubject($employeeWhoAppliedLeaveForOthers . ' Applied for Leave  of '.$LeaveTakenForOthersName.' #' . rand(108512, 709651))
                            ->setViewVars([
                                'employeeWhoAppliedLeaveForOthers' => $employeeWhoAppliedLeaveForOthers,
                                'LeaveTakenForOthersName' => $LeaveTakenForOthersName,
                                'date_from' => $LeaveRequestsForm['date_from'],
                                'date_to' => $LeaveRequestsForm['date_to'],
                                'leave_reason' => $LeaveRequestsForm['leave_reason'],
                                'reliever_name' => $leaveRequest['reliever_name'],
                                'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                                'leaveId' => $leaveRequest->id,
                                'no_of_days' => $LeaveRequestsForm['no_of_days'],
                                'leave_type' => $this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                            ->send();
                    }
                    $this->Flash->success(__('The leave request has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Please check the message'));
                }
            }else{
               return $this->Flash->error(__('The leave request could not be saved. Please, try again.'));
            }
        }else {
            $employees = $this->Employees->find('list', [
                'keyField' => 'id',
                'valueField' => function ($e) {
                    return $e->first_name . ' ' . $e->last_name;
                },
                array(
                    'order' => array('("first_name") ASC')
                )]
            );
            $employees = $employees->toArray();
            $employees[''] = 'Select Employee';

            // Adding employee as reliever from respective office.
            $relieverList = $this->Employees->find('all')->WHERE(['employment_status' => 1])->toArray();
            $reliever =  array();
            foreach($relieverList as $RL){
                $relieverId = $RL['id'];
                $relieverName = $RL['first_name'].' '.$RL['last_name'];
                $reliever[$relieverId] = $relieverName;
            }

            $leaveRequest = $this->EmpLeaves->newEntity();
            $this->set(compact('employees', 'leaveRequest', 'reliever'));
        }
    }

    public function officeLocation()
    {
        if ($this->request->is('post')) {
            $this->loadModel('EmpLeaves');
            $this->loadModel('Employees');
            $filterData = $this->request->getData();
            $employees = $this->Employees->get($filterData['empId']);
            $empOffcLoc = $employees->office_location;
            $empType = $employees->employment_type;
            

            $getLeaveDays = $this->EmpLeaves->totalLeaveData($filterData['empId']);
            if($getLeaveDays == null){
                $this->Flash->success(__('No Leave days has been assigned. Please contact HR.'));
                return $this->redirect(['controller'=>'employees','action' => 'dashboard']);
            }

            if(empty($getLeaveDays)){
                $getLeaveDays['sick_leave'] = 0;
                $getLeaveDays['casual_leave']= 0;
                $getLeaveDays['earned_leave']= 0;
                $getLeaveDays['unplanned_leave']= 0;
                $getLeaveDays['planned_leave']= 0;
                $getLeaveDays['restricted_leave']= 0;
                $getLeaveDays['day_off']= 0;
            }

            // Sick Leave Info For Full Day
            $half_sick_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],1);
            $sick_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],1,'sick_leave_taken')+$half_sick_taken;
            $remainingSickLeave = $getLeaveDays['sick_leave'];

            // LWoP Leave Info For Full Day
            $half_LWoP_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],3);
            $LWoP_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],3,'lwop_leave_taken')+$half_LWoP_taken;

            // Earned Leave Info for Full Day
            $half_earned_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],4);
            $earned_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],4,'earned_leave_taken')+$half_earned_taken;
            $remainingEarnedLeave = $getLeaveDays['earned_leave'];

            $half_unplanned_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],5);
            $unplanned_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],5,'unplanned_leave_taken')+$half_unplanned_taken;
            $remainingUnplannedLeave = $getLeaveDays['unplanned_leave'];

            $half_planned_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],6);
            $planned_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],6,'planned_leave_taken')+$half_planned_taken;
            $remainingPlannedLeave = $getLeaveDays['planned_leave'];

            $half_restricted_holiday_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],7);
            $restricted_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],7,'restricted_leave_taken') + $half_restricted_holiday_taken;
            $remainingRestrictedLeave = $getLeaveDays['restricted_leave'];

            $half_day_off_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],8);
            $dayOffTaken = $this->EmpLeaves->fullDayLeave($filterData['empId'],8,'day_off_taken') + $half_day_off_taken;
            $remainingDayOffLeave = $getLeaveDays['day_off'];

            //check if user is an intern or other
            if($employees->employment_type == 'intern'){
                $casual_taken = "0";
            } 
            else {        
                // Full Casual Leave Info
                $half_casual_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],2);
                $casual_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],2,'casual_leave_taken')+$half_casual_taken;
                // calculation for total causal leave
                $remainingCasualLeave=$getLeaveDays['casual_leave'];
            }

            $totalLeaveTaken = $this->EmpLeaves->totalLeave($sick_taken,$casual_taken,$LWoP_taken,$earned_taken);
            $totalLeaveTakenForGoa =  $this->EmpLeaves->totalLeaveForGoa($LWoP_taken,$unplanned_taken,$planned_taken,$restricted_taken);

        } else {
            $empOffcLoc = '';
            $empType = '';
        }
        $this->set(compact('empOffcLoc', 'empType', 'sick_taken','casual_taken','LWoP_taken','earned_taken','unplanned_taken','planned_taken','remainingUnplannedLeave','remainingPlannedLeave','totalLeaveTaken','totalLeaveTakenForGoa', 'remainingSickLeave','remainingCasualLeave','restricted_taken','remainingRestrictedLeave','remainingEarnedLeave','dayOffTaken','remainingDayOffLeave'));
    }

    public function reliever()
    {
        if ($this->request->is('post')) {
            $this->loadModel('EmpLeaves');
            $this->loadModel('Employees');
            $filterData = $this->request->getData();
            $employees = $this->Employees->get($filterData['empId']);
            
            $empOffcLoc = $employees->office_location;
            $employeeId = $employees->id;
            $empType = $employees->employment_type;
            
        // Adding employee as reliever from respective office.
        $this->loadModel('Employees');
        $relieverList = $this->Employees->find('all')->WHERE(['id !=' => $employeeId, 'employment_status' => 1])->ORDER(['first_name'=>'ASC'])->toArray();
        $reliever =  array();
        foreach($relieverList as $RL){
            $relieverName = $RL['first_name'].' '.$RL['last_name'];
            $reliever[$relieverName] = $relieverName;
        }
            if(empty($getLeaveDays)){
                $getLeaveDays['sick_leave'] = 0;
                $getLeaveDays['casual_leave']= 0;
                $getLeaveDays['earned_leave']= 0;
                $getLeaveDays['unplanned_leave']= 0;
                $getLeaveDays['planned_leave']= 0;
                $getLeaveDays['restricted_leave']= 0;
                $getLeaveDays['day_off']= 0;
            }

            // Sick Leave Info For Full Day
            $half_sick_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],1);
            $sick_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],1,'sick_leave_taken')+$half_sick_taken;
            $remainingSickLeave = $getLeaveDays['sick_leave'];

            // LWoP Leave Info For Full Day
            $half_LWoP_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],3);
            $LWoP_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],3,'lwop_leave_taken')+$half_LWoP_taken;

            // Earned Leave Info for Full Day
            $half_earned_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],4);
            $earned_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],4,'earned_leave_taken')+$half_earned_taken;
            $remainingEarnedLeave = $getLeaveDays['earned_leave'];

            $half_unplanned_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],5);
            $unplanned_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],5,'unplanned_leave_taken')+$half_unplanned_taken;
            $remainingUnplannedLeave = $getLeaveDays['unplanned_leave'];

            $half_planned_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],6);
            $planned_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],6,'planned_leave_taken')+$half_planned_taken;
            $remainingPlannedLeave = $getLeaveDays['planned_leave'];

            $half_restricted_holiday_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],7);
            $restricted_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],7,'restricted_leave_taken') + $half_restricted_holiday_taken;
            $remainingRestrictedLeave = $getLeaveDays['restricted_leave'];

            $half_day_off_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],8);
            $dayOffTaken = $this->EmpLeaves->fullDayLeave($filterData['empId'],8,'day_off_taken') + $half_day_off_taken;
            $remainingDayOffLeave = $getLeaveDays['day_off'];

            //check if user is an intern or other
            if($employees->employment_type == 'intern'){
                $casual_taken = "0";
            } 
            else {        
                // Full Casual Leave Info
                $half_casual_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],2);
                $casual_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],2,'casual_leave_taken')+$half_casual_taken;
                // calculation for total causal leave
                $remainingCasualLeave=$getLeaveDays['casual_leave'];
            }

            $totalLeaveTaken = $this->EmpLeaves->totalLeave($sick_taken,$casual_taken,$LWoP_taken,$earned_taken);
            $totalLeaveTakenForGoa =  $this->EmpLeaves->totalLeaveForGoa($LWoP_taken,$unplanned_taken,$planned_taken,$restricted_taken);

        } 
        $this->set(compact('empOffcLoc', 'reliever','empType', 'sick_taken','casual_taken','LWoP_taken','earned_taken','unplanned_taken','planned_taken','remainingUnplannedLeave','remainingPlannedLeave','totalLeaveTaken','totalLeaveTakenForGoa', 'remainingSickLeave','remainingCasualLeave','restricted_taken','remainingRestrictedLeave','remainingEarnedLeave','dayOffTaken','remainingDayOffLeave'));
    }


    public function leaveTaken()
    {
        if ($this->request->is('post')) {
            $this->loadModel('EmpLeaves');
            $this->loadModel('Employees');
            $filterData = $this->request->getData();
            $employees = $this->Employees->get($filterData['empId']);
            $empOffcLoc = $employees->office_location;

            $getLeaveDays = $this->EmpLeaves->totalLeaveData($filterData['empId']);
            if($getLeaveDays == null){
                $this->Flash->success(__('No Leave days has been assigned. Please contact HR.'));
                return $this->redirect(['controller'=>'employees','action' => 'dashboard']);
            }

            if(empty($getLeaveDays)){
                $getLeaveDays['sick_leave'] = 0;
                $getLeaveDays['casual_leave']= 0;
                $getLeaveDays['earned_leave']= 0;
                $getLeaveDays['unplanned_leave']= 0;
                $getLeaveDays['planned_leave']= 0;
                $getLeaveDays['restricted_leave']= 0;
                $getLeaveDays['day_off']= 0;
            }

            // Sick Leave Info For Full Day
            $half_sick_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],1);
            $sick_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],1,'sick_leave_taken')+$half_sick_taken;
            $remainingSickLeave = $getLeaveDays['sick_leave'];

            // LWoP Leave Info For Full Day
            $half_LWoP_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],3);
            $LWoP_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],3,'lwop_leave_taken')+$half_LWoP_taken;

            // Earned Leave Info for Full Day
            $half_earned_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],4);
            $earned_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],4,'earned_leave_taken')+$half_earned_taken;
            $remainingEarnedLeave = $getLeaveDays['earned_leave'];

            $half_unplanned_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],5);
            $unplanned_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],5,'unplanned_leave_taken')+$half_unplanned_taken;
            $remainingUnplannedLeave = $getLeaveDays['unplanned_leave'];

            $half_planned_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],6);
            $planned_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],6,'planned_leave_taken')+$half_planned_taken;
            $remainingPlannedLeave = $getLeaveDays['planned_leave'];

            $half_restricted_holiday_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],7);
            $restricted_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],7,'restricted_leave_taken') + $half_restricted_holiday_taken;
            $remainingRestrictedLeave = $getLeaveDays['restricted_leave'];

            $half_day_off_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],8);
            $dayOffTaken = $this->EmpLeaves->fullDayLeave($filterData['empId'],8,'day_off_taken') + $half_day_off_taken;
            $remainingDayOffLeave = $getLeaveDays['day_off'];

            //check if user is an intern or other
            if($employees->employment_type == 'intern'){
                $casual_taken = "0";
            } 
            else {        
                // Full Casual Leave Info
                $half_casual_taken = $this->EmpLeaves->halfDayLeave($filterData['empId'],2);
                $casual_taken = $this->EmpLeaves->fullDayLeave($filterData['empId'],2,'casual_leave_taken')+$half_casual_taken;
                // calculation for total causal leave
                $remainingCasualLeave=$getLeaveDays['casual_leave'];
            }

            $totalLeaveTaken = $this->EmpLeaves->totalLeave($sick_taken,$casual_taken,$LWoP_taken,$earned_taken);
            $totalLeaveTakenForGoa =  $this->EmpLeaves->totalLeaveForGoa($LWoP_taken,$unplanned_taken,$planned_taken,$restricted_taken);

            $this->set(compact('empOffcLoc', 'sick_taken','casual_taken','LWoP_taken','earned_taken','unplanned_taken','planned_taken','remainingUnplannedLeave','remainingPlannedLeave','totalLeaveTaken','totalLeaveTakenForGoa', 'remainingSickLeave','remainingCasualLeave','restricted_taken','remainingRestrictedLeave','remainingEarnedLeave','dayOffTaken','remainingDayOffLeave'));

        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    { 
        // User info
        $loggedUserName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $loggedUserId = $this->Auth->user('id');
        $loggedInUserInfo = $this->EmpLeaves->find('all')->WHERE(['reliever LIKE' => ','.$loggedUserId, 'reliever_approved LIKE' => ','.$loggedUserId, 'is_approved !=' => 2])->toArray();
        $employeeId = $this->Auth->user('id');
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $employeeReportingManager = $this->Auth->user('reporting_manager');
        $employeeType = $this->Auth->user('employment_type');
        $employeeOfficeLocation = $this->Auth->user('office_location');
        $employeeDesignationId="";

        //validation
        $this->loadModel('EmpLeaves');
        $getLeaveDays = $this->EmpLeaves->totalLeaveData($employeeId);
        if($getLeaveDays == null){
            $this->Flash->success(__('No Leave days has been assigned. Please contact with HR.'));
            return $this->redirect(['controller'=>'employees','action' => 'dashboard']);
        }
        // Adding employee as reliever from respective office.
        $this->loadModel('Employees');
        $relieverList = $this->Employees->find('all')->WHERE(['id !=' => $employeeId, 'employment_status' => 1])->toArray();
        $reliever =  array();
        foreach($relieverList as $RL){
            $relieverId = $RL['id'];
            $relieverName = $RL['first_name'].' '.$RL['last_name'];
            $reliever[$relieverId] = $relieverName;
        }

        if(empty($getLeaveDays)){
            $getLeaveDays['sick_leave'] = 0;
            $getLeaveDays['casual_leave']= 0;
            $getLeaveDays['earned_leave']= 0;
            $getLeaveDays['unplanned_leave']= 0;
            $getLeaveDays['planned_leave']= 0;
            $getLeaveDays['restricted_leave']= 0;
            $getLeaveDays['day_off']= 0;
        }

        $reportingManagerId = $this->Auth->user('reporting_manager');
     
        $reportingManagerEmail = $this->EmpLeaves->reportingManagerEmail($reportingManagerId);

        // Sick Leave Info For Full Day
        $half_sick_taken = $this->EmpLeaves->halfDayLeave($employeeId,1);

        $sick_taken = $this->EmpLeaves->fullDayLeave($employeeId,1,'sick_leave_taken')+$half_sick_taken;
        $remainingSickLeave = $getLeaveDays['sick_leave'];

        // LWoP Leave Info For Full Day
        $half_LWoP_taken = $this->EmpLeaves->halfDayLeave($employeeId,3);
        $LWoP_taken = $this->EmpLeaves->fullDayLeave($employeeId,3,'lwop_leave_taken')+$half_LWoP_taken;

        // Earned Leave Info for Full Day
        $half_earned_taken = $this->EmpLeaves->halfDayLeave($employeeId,4);
        $earned_taken = $this->EmpLeaves->fullDayLeave($employeeId,4,'earned_leave_taken')+$half_earned_taken;
        $remainingEarnedLeave = $getLeaveDays['earned_leave'];

        $half_unplanned_taken = $this->EmpLeaves->halfDayLeave($employeeId,5);
        $unplanned_taken = $this->EmpLeaves->fullDayLeave($employeeId,5,'unplanned_leave_taken')+$half_unplanned_taken;
        $remainingUnplannedLeave = $getLeaveDays['unplanned_leave'];

        $half_planned_taken = $this->EmpLeaves->halfDayLeave($employeeId,6);
        $planned_taken = $this->EmpLeaves->fullDayLeave($employeeId,6,'planned_leave_taken')+$half_planned_taken;
        $remainingPlannedLeave = $getLeaveDays['planned_leave'];

        $half_restricted_holiday_taken = $this->EmpLeaves->halfDayLeave($employeeId,7);
        $restricted_taken = $this->EmpLeaves->fullDayLeave($employeeId,7,'restricted_leave_taken')+$half_restricted_holiday_taken;
        $remainingRestrictedLeave = $getLeaveDays['restricted_leave'];

        $half_day_off_taken = $this->EmpLeaves->halfDayLeave($employeeId,8);
        $dayOffTaken = $this->EmpLeaves->fullDayLeave($employeeId,8,'day_off_taken')+$half_day_off_taken;
        $remainingDayOffLeave = $getLeaveDays['day_off'];
     
       //check if user is an intern or other
        if($employeeType == 'intern'){
            $casual_taken = "0";
        } 
        else {        
            // Full Casual Leave Info
            $half_casual_taken = $this->EmpLeaves->halfDayLeave($employeeId,2);
            $casual_taken = $this->EmpLeaves->fullDayLeave($employeeId,2,'casual_leave_taken')+$half_casual_taken;
            // calculation for total causal leave
            $remainingCasualLeave=$getLeaveDays['casual_leave'];
        }

            $leavesOfEmployee['sick_taken']= $remainingSickLeave ;
            $leavesOfEmployee['remainingEarnedLeave']=$remainingEarnedLeave;
            $leavesOfEmployee['remainingUnplannedLeave']=$remainingUnplannedLeave;
            $leavesOfEmployee['remainingPlannedLeave']=$remainingPlannedLeave;
            $leavesOfEmployee['remainingRestrictedLeave']=$remainingRestrictedLeave;
            $leavesOfEmployee['remainingDayOffLeave']=$remainingDayOffLeave;
            $leavesOfEmployee['remainingCasualLeave']=$remainingCasualLeave;
            $totalLeaveTaken = $this->EmpLeaves->totalLeave($sick_taken,$casual_taken,$LWoP_taken,$earned_taken);
            $totalLeaveTakenForGoa =  $this->EmpLeaves->totalLeaveForGoa($LWoP_taken,$unplanned_taken,$planned_taken,$restricted_taken);
            $leaveRequest = $this->EmpLeaves->newEntity();
        //Code to be executed if form is submitted.
        if ($this->request->is('post')){
            $noOfDays=$this->request->getData(['no_of_days']);
            $leaveType=$this->request->getData(['leave_type']);
            $LeaveRequestsForm = $this->request->getData();
            $requestedDateForm = date('Y-m-d', strtotime($this->request->getData(['date_from'])));
            $requestedDateTo = date('Y-m-d', strtotime($this->request->getData(['date_to'])));
            $loggedInUserLeaveRequestWhenPending = $this->EmpLeaves
                                                        ->find('all')
                                                        ->WHERE(['employee_name'=>$loggedUserName, 
                                                                 'date_from' => $requestedDateForm, 
                                                                 'is_approved' => 0,
                                                                 'emp_leave_cancellation !='=>1])
                                                        ->toArray();
            if($loggedInUserLeaveRequestWhenPending) {
                $this->Flash->error(__('You already Apply leave request for this day and leave request is on pending'));
                return $this->redirect(['action' => 'index']);
            }

            $loggedInUserLeaveRequestWhenApproved = $this->EmpLeaves->find('all')->WHERE(['employee_name'=>$loggedUserName, 'date_from' => $requestedDateForm, 'is_approved' => 1])->toArray();
            if($loggedInUserLeaveRequestWhenApproved){
                 $this->Flash->error(__('Your leave request has been already approved for this day'));
                return $this->redirect(['action' => 'index']);
            }

           switch($leaveType) {
                    case 1:{ $remainingLeave=$leavesOfEmployee['sick_taken'] ; break; }
                    case 2:{ $remainingLeave=$leavesOfEmployee['remainingCasualLeave']; break; }
                    case 3:{ break; }
                    case 4:{ $remainingLeave=$leavesOfEmployee['remainingEarnedLeave'];  break; }
                    case 5:{ $remainingLeave=$leavesOfEmployee['remainingUnplannedLeave']; break; }
                    case 6:{ $remainingLeave=$leavesOfEmployee['remainingPlannedLeave']; break; }
                    case 7:{ $remainingLeave=$leavesOfEmployee['remainingRestrictedLeave'];  break; }
            }

          $remainingTotalleaves=(float)$remainingLeave-(float)$noOfDays;
          
          if($remainingTotalleaves >= 0.0 || $leaveType==3 ) {
                foreach($loggedInUserInfo as $loggedInUserInfos)
                {
                    $loggedInUserDateForm = date('Y-m-d',strtotime($loggedInUserInfos->date_from));
                    $loggedInUserDateTo = date('Y-m-d',strtotime($loggedInUserInfos->date_to));
                    if(($loggedInUserDateForm == $requestedDateForm || $loggedInUserDateTo == $requestedDateTo))
                    {
                        $this->Flash->error(__('You can not apply for this day, bacause you are the reliever on that day for '.$loggedInUserInfos->employee_name));
                        return $this->redirect(['action' => 'index']);
                    }
                }

                $LeaveRequestsForm = $this->request->getData();
                $selectedReliever = $LeaveRequestsForm['list'];
                $LeaveRequestsForm = $this->EmpLeaves->convertStringtoDateFormat($LeaveRequestsForm);
                $leaveRequest = $this->EmpLeaves->patchEntity($leaveRequest, $LeaveRequestsForm);
                $cnt = 0;
                $relieverDetails=[];
                foreach ($selectedReliever as $r) {
                    $hasRelieverRequestedleave=$this->EmpLeaves->find("all")
                                                    ->where(['OR'=>['employee_id'=>$r,
                                                                    'reliever like'=>'%,'.$r.'%'
                                                                ],
                                                            'DATE(date_from) >='=>date("Y-m-d",strtotime($requestedDateForm)),
                                                            'DATE(date_to) <='=> date("Y-m-d",strtotime($requestedDateTo)),
                                                            'is_approved !='=>'2',
                                                            'emp_leave_cancellation !='=>1
                                                            ])
                                                    ->toArray(); 

                    if((!empty($hasRelieverRequestedleave))){
                        $this->Flash->error(__($this->EmpLeaves->getNameFromId($r)." cannot be assigned as reliever as he/she has already requested leave or has been selected as reliever for this date. Please choose another employee as reliever"));
                        return $this->redirect(['action' => 'index']);
                    }

                    if($cnt == 0) {
                        $relieverDetails[$cnt]['email']=$this->EmpLeaves->employeeEmail($r);
                        $relieverDetails[$cnt]['name']=$this->EmpLeaves->getNameFromId($r);
                        $leaveRequest->reliever_name =$this->EmpLeaves->getNameFromId($r);
                        $leaveRequest->reliever = ",".$r;
                    }else {
                        $relieverDetails[$cnt]['email']=$this->EmpLeaves->employeeEmail($r);
                        $relieverDetails[$cnt]['name']=$this->EmpLeaves->getNameFromId($r);
                        $leaveRequest->reliever_name .= ", ".$this->EmpLeaves->getNameFromId($r);
                        $leaveRequest->reliever .= ",".$r;
                    }
                    $cnt++;
                }
                
                $leaveRequest->test = "1";
                $reportingManagerId = $this->Auth->user('reporting_manager');
                $reportingManagerEmail = $this->EmpLeaves->reportingManagerEmail($reportingManagerId);
                $leaveRequest->no_of_days = $LeaveRequestsForm['no_of_days'];
                $leaveRequest->sick_leave_taken = 0;
                $leaveRequest->casual_leave_taken = 0;
                $leaveRequest->lwop_leave_taken	= 0;
                $leaveRequest->earned_leave_taken = 0;
                $leaveRequest->unplanned_leave_taken = 0;
                $leaveRequest->planned_leave_taken = 0;
                $leaveRequest->restricted_leave_taken = 0;
                $leaveRequest->day_off_taken = 0;
                $leaveRequest->half_day_taken = 0;
            //new code for leave request cancelation for users and employess
                if($leaveRequest->no_of_days === '1' || $leaveRequest->no_of_days === '0.5')
                {
                    if ($this->EmpLeaves->save($leaveRequest)) {
                        $applierEmail = $this->Auth->user('office_email');
                        $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
                        $emailTo = array();
                        $emailTo[] = $reportingManagerEmail;
                        if($reportingManagerEmail != null) {
                            $email = new Email();
                            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                                ->setto($emailTo)
                                ->setemailFormat('html')
                                ->setTemplate('lr_apply')
                                ->setsubject($applierName . ' Applied for Leave #' . rand(108512, 709651))
                                ->setViewVars(['applierName' => $applierName,
                                    'date_from' => $LeaveRequestsForm['date_from'],
                                    'date_to' => $LeaveRequestsForm['date_to'],
                                    'leave_reason' => $LeaveRequestsForm['leave_reason'],
                                    'reliever_name' => $leaveRequest['reliever_name'],
                                    'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                                    'leaveId' => $leaveRequest->id,
                                    'no_of_days' => $LeaveRequestsForm['no_of_days'],
                                    'leave_type' => $this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                                ->send();
                        }
                    //  send email to manager regarding the number of leaves remaining and leaves taken i 
                        if($reportingManagerEmail != null) {
                            $last30Days=date("Y-m-d",strtotime('today - 30 days'));
                            $query= $this->EmpLeaves->find();
                            $leavesTaken=$query->select(['count' => $query->func()->count('*')])->where(['employee_id'=>$employeeId,'created >'=>$last30Days,'leave_type'=>$LeaveRequestsForm['leave_type']])->toList();
                            $email = new Email();
                            $email->setFrom(['connect@sjinnovation.com' => 'SJ Connect'])
                                ->setTo($reportingManagerEmail)
                                ->setEmailFormat('html')
                                ->setTemplate('mail_to_manager_for_leaves_taken_last_30dy')
                                ->setSubject($applierName . ' Applied for Leave #' . rand(108512, 709651))
                                ->setViewVars(['applierName' => $applierName,
                                    'date_from' => $LeaveRequestsForm['date_from'],
                                    'date_to' => $LeaveRequestsForm['date_to'],
                                    'leaveId' => $leaveRequest->id,
                                    'leavesOfEmployee'=>$leavesOfEmployee,
                                    'leavesTakenInLast30Days' =>$leavesTaken[0]['count'],
                                    'office_location'=>$employeeOfficeLocation,
                                    'no_of_days' => $LeaveRequestsForm['no_of_days'],
                                    'leave_type' => $this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                                ->send();
                        }

                        $this->sendMailToRelivers($relieverDetails,$applierName,$LeaveRequestsForm['date_from'],$LeaveRequestsForm['date_to'],$LeaveRequestsForm['no_of_days'],$this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type']));
                        $this->Flash->success(__('Your leave request has been submitted successfully.'));
                        return $this->redirect(['action' => 'index']);
                    }
                } else if($leaveRequest->no_of_days > 1 && $leaveRequest->no_of_days < 7) {
                    $leavesAll=[];
                    $dayofweek=[];
                    $i=0;
                    $j=0;
                    $skipdays=["Saturday","Sunday"];
                    while($i < $leaveRequest->no_of_days) {
                        $day = $j. ' day';
                        $dayname=date('l', strtotime($day,strtotime($this->request->getData(['date_from']))));
                        if(!in_array($dayname,$skipdays)){
                            $var = $this->EmpLeaves->newEntity();
                            $dayofweek[] = date('l', strtotime($day,strtotime($this->request->getData(['date_from']))));

                            $var->date_from = date('Y-m-d', strtotime($day,strtotime($this->request->getData(['date_from']))));
                            $var->date_to = date('Y-m-d', strtotime($day,strtotime($this->request->getData(['date_from']))));

                            $var->employee_id = $this->Auth->user('id');
                            $var->employee_name = $this->request->getData(['employee_name']);
                            $var->reporting_managerId = $this->request->getData(['reporting_managerId']);
                            $var->leave_type = $this->request->getData(['leave_type']);
                            $var->no_of_days = 1;
                            $var->half_day = $this->request->getData(['half_day']);
                            $var->leave_reason = $this->request->getData(['leave_reason']);
                            $var->reliver = $this->request->getData(['reliever']);
                            $var->reliever_name = $this->request->getData(['reliever_name']);
                            $cnt = 0;
                            foreach ($selectedReliever as $r) {
                                if($cnt == 0) {
                                    $var->reliever = ",".$r;
                                    $var->reliever_name = $this->EmpLeaves->getNameFromId($r);
                                }
                                else {
                                    $var->reliever .= ",".$r;
                                    $var->reliever_name .= ", ".$this->EmpLeaves->getNameFromId($r);
                                }
                                $cnt++;
                            }
                            $valueSaved = $this->EmpLeaves->save($var);
                            $i++;
                        } 
                        $j++;
                    }
                if($valueSaved) {
                    //newcode for sending email
                    $applierEmail = $this->Auth->user('office_email');
                    $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
                    $emailTo = array();
                    $emailTo[] = $reportingManagerEmail;
                    if($reportingManagerEmail != null) {
                        $email = new Email();
                        $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                            ->setto($emailTo)
                            // ->setCc('hr@managedcoder.com')
                            ->setemailFormat('html')
                            ->setTemplate('lr_apply')
                            ->setsubject($applierName . ' Applied for Leave #' . rand(108512, 709651))
                            ->setViewVars(['applierName' => $applierName,
                                'date_from' => $LeaveRequestsForm['date_from'],
                                'date_to' => $LeaveRequestsForm['date_to'],
                                'leave_reason' => $LeaveRequestsForm['leave_reason'],
                                'reliever_name' => $leaveRequest['reliever_name'],
                                'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                                'leaveId' => $leaveRequest->id,
                                'no_of_days' => $LeaveRequestsForm['no_of_days'],
                                'leave_type' => $this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                            ->send();
                    }
                }
                    if($reportingManagerEmail != null) {
                        $last30Days=date("Y-m-d",strtotime('today - 30 days'));
                        $query= $this->EmpLeaves->find();
                        $leavesTaken=$query->select(['count' => $query->func()->count('*')])->where(['employee_id'=>$employeeId,'created >'=>$last30Days,'leave_type'=>$LeaveRequestsForm['leave_type']])->toList();
                        $email = new Email();
                        $email->setFrom(['connect@sjinnovation.com' => 'SJ Connect'])
                            ->setTo($reportingManagerEmail)
                            ->setEmailFormat('html')
                            ->setTemplate('mail_to_manager_for_leaves_taken_last_30dy')
                            ->setSubject($applierName . ' Applied for Leave #' . rand(108512, 709651))
                            ->setViewVars(['applierName' => $applierName,
                                'date_from' => $LeaveRequestsForm['date_from'],
                                'date_to' => $LeaveRequestsForm['date_to'],
                                'leaveId' => $leaveRequest->id,
                                'leavesOfEmployee'=>$leavesOfEmployee,
                                'leavesTakenInLast30Days' =>$leavesTaken[0]['count'],
                                'office_location'=>$employeeOfficeLocation,
                                'no_of_days' => $LeaveRequestsForm['no_of_days'],
                                'leave_type' => $this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                            ->send();
                     }

                    $this->sendMailToRelivers($relieverDetails,$applierName,$LeaveRequestsForm['date_from'],$LeaveRequestsForm['date_to'],$LeaveRequestsForm['no_of_days'],$this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type']));
                    $this->Flash->success(__('Your leave request has been submitted successfully'));
                    return $this->redirect(['action' => 'index']);
                }
                else {
                    $this->Flash->error(__('Your leave has not been submitted,Please check it again and re-submit it.'));
                }
            }else{
                $this->Flash->error(__('Your leave has not been submitted, The number of days requested is more then the your leave balance.'));
            }
        }
        $employees = $this->EmpLeaves->Employees->find('list', ['limit' => 200]);
        $this->set(compact('leaveRequest','employeeOfficeLocation','reliever', 'employees','employeeName','employeeReportingManager','employeeId','sick_taken','casual_taken','LWoP_taken','earned_taken','unplanned_taken','planned_taken','remainingUnplannedLeave','remainingPlannedLeave','totalLeaveTaken','totalLeaveTakenForGoa','employeeDesignationId','remainingSickLeave','remainingCasualLeave','restricted_taken','remainingRestrictedLeave','remainingEarnedLeave','dayOffTaken','remainingDayOffLeave','employeeType'));
    }

    public function saveEmployeeRequest($leaveRequest, $remainingDays, $reportingManagerEmail, $LeaveRequestsForm) {

        if ($this->EmpLeaves->save($leaveRequest)) {
            $applierEmail = $this->Auth->user('office_email');
            $applierName = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
            $employeeWhoAppliedLeaveRequest = $leaveRequest->employee_name;
            $employeeWhoAppliedLeaveRequestOfficeEmail = $leaveRequest->employee->office_email;

            $emailTo = array();
            $emailTo[] = $reportingManagerEmail;

            if($reportingManagerEmail != null) {
                $email = new Email();
                $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                    ->setto($emailTo)
                    ->setCc('hr@managedcoder.com')
                    ->setemailFormat('html')
                    ->setTemplate('lr_update')
                    ->setsubject($applierName . ' updated for Leave #' . rand(108512, 709651))
                    ->setViewVars(['applierName' => $applierName,
                        'leaveRequestFrom' => $leaveRequest['employee_name'] == $applierName ? "" : $leaveRequest['employee_name'],
                        'date_from' => $LeaveRequestsForm['date_from'],
                        'date_to' => $LeaveRequestsForm['date_to'],
                        'leave_reason' => $LeaveRequestsForm['leave_reason'],
                        'reliever' => $leaveRequest->reliever_name,
                        'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                        'leaveId' => $leaveRequest->id,
                        'no_of_days' => $LeaveRequestsForm['no_of_days'],
                        'leave_type' => $this->EmpLeaves->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                    ->send();
            } else { }
            $this->Flash->success(__('The leave request has been submitted successfully.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Your leave has not been submitted,Please check it again and re-submit it'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Emp Leave id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $leaveRequest = $this->EmpLeaves->get($id, [
            'contain' => ['Employees']
        ]);
        $previousSelectedReliever = $leaveRequest->reliever;
        $previousSelectedRelieverList = explode(",", $previousSelectedReliever);

        // User info
        $employeeId = $this->Auth->user('id');
        // added by anik to fix the leave days value error on employee add request page and hr edit request page
        $employeeIdAppliedLeave = $leaveRequest->employee_id; // end added by anik to fix the leave days value error on employee add request page and hr edit request page

        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $employeeReportingManager = $this->Auth->user('reporting_manager');
        $employeeType = $this->Auth->user('employment_type');
        $employeeOfficeLocation = $leaveRequest->employee->office_location;

        //new code 
        $getLeaveDays = $this->EmpLeaves->totalLeaveData($leaveRequest->employee_id);
        if(empty($getLeaveDays)){
            $getLeaveDays['sick_leave'] = 0;
            $getLeaveDays['casual_leave']= 0;
            $getLeaveDays['earned_leave']= 0;
            $getLeaveDays['unplanned_leave']= 0;
            $getLeaveDays['planned_leave']= 0;
            $getLeaveDays['restricted_leave']= 0;
            $getLeaveDays['day_off']= 0;
        }

        // Adding employee as reliever from respective office.
        $this->loadModel('Employees');
        $relieverList = $this->Employees->find('all')->WHERE(['id !=' => $employeeIdAppliedLeave, 'employment_status' => 1])->toArray();
        $reliever =  array();
        foreach($relieverList as $RL){
            $relieverId = $RL['id'];
            $relieverName = $RL['first_name'].' '.$RL['last_name'];
            $reliever[$relieverId] = $relieverName;
        }

        /*Sick Leave Info */
        $half_sick_taken = $this->EmpLeaves->halfDayLeave($employeeIdAppliedLeave,1);//for half day
        $sick_taken = $this->EmpLeaves->fullDayLeave($employeeIdAppliedLeave,1,'sick_leave_taken')+$half_sick_taken;//for full day
        $remainingSickLeave = $getLeaveDays['sick_leave']; //remaining sick leave
        /*LWOP Leave Info */
        $half_LWoP_taken = $this->EmpLeaves->halfDayLeave($employeeIdAppliedLeave,3);//for half day
        $LWoP_taken = $this->EmpLeaves->fullDayLeave($employeeIdAppliedLeave,3,'lwop_leave_taken')+$half_LWoP_taken;//for full day

        /* Earned Leave Info */
        $half_earned_taken = $this->EmpLeaves->halfDayLeave($employeeIdAppliedLeave,4);//for half day
        $earned_taken = $this->EmpLeaves->fullDayLeave($employeeIdAppliedLeave,4,'earned_leave_taken')+$half_earned_taken;//for full day
        $remainingEarnedLeave = $getLeaveDays['earned_leave'];//remaining Earned Leave

        $half_unplanned_taken = $this->EmpLeaves->halfDayLeave($employeeIdAppliedLeave,5);
        $unplanned_taken = $this->EmpLeaves->fullDayLeave($employeeIdAppliedLeave,5,'unplanned_leave_taken')+$half_unplanned_taken;
        $remainingUnplannedLeave = $getLeaveDays['unplanned_leave'];

        $half_planned_taken = $this->EmpLeaves->halfDayLeave($employeeIdAppliedLeave,6);
        $planned_taken = $this->EmpLeaves->fullDayLeave($employeeIdAppliedLeave,6,'planned_leave_taken')+$half_planned_taken;
        $remainingPlannedLeave = $getLeaveDays['planned_leave'];

        $half_restricted_holiday_taken = $this->EmpLeaves->halfDayLeave($employeeIdAppliedLeave,7);
        $restricted_taken = $this->EmpLeaves->fullDayLeave($employeeIdAppliedLeave,7,'restricted_leave_taken') + $half_restricted_holiday_taken;
        $remainingRestrictedLeave = $getLeaveDays['restricted_leave'];

        //check if user is an intern or other
        if($employeeType == 'intern'){
            $casual_taken = "0";
        } 
        else {        
            /*Full Casual Leave Info */
            $half_casual_taken = $this->EmpLeaves->halfDayLeave($employeeIdAppliedLeave,2);//for half day
            $casual_taken = $this->EmpLeaves->fullDayLeave($employeeIdAppliedLeave,2,'casual_leave_taken')+$half_casual_taken;//for full day
            $remainingCasualLeave=$getLeaveDays['casual_leave'];//remaining casual leave
        }   

        $totalLeaveTaken = $this->EmpLeaves->totalLeave($sick_taken,$casual_taken,$LWoP_taken,$earned_taken);
        $totalLeaveTakenForGoa =  $this->EmpLeaves->totalLeaveForGoa($LWoP_taken,$unplanned_taken,$planned_taken,$restricted_taken);

        //new code

        $employeePreviousLeaveType = $leaveRequest->leave_type;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $LeaveRequestsForm = $this->request->getData();

            if(isset($LeaveRequestsForm['hidden_date_from_for_approved'])) {
                $LeaveRequestsForm['date_from'] = $LeaveRequestsForm['hidden_date_from_for_approved'];
            }

            if(isset($LeaveRequestsForm['hidden_date_to_for_approved'])) {
                $LeaveRequestsForm['date_to'] = $LeaveRequestsForm['hidden_date_to_for_approved'];
            }

            if(isset($LeaveRequestsForm['hidden_leave_reason_for_approved'])) {
                $LeaveRequestsForm['leave_reason'] = $LeaveRequestsForm['hidden_leave_reason_for_approved'];
            }

            if(isset($LeaveRequestsForm['hidden_reliever_for_approved'])) {
                $LeaveRequestsForm['reliever'] = $LeaveRequestsForm['hidden_reliever_for_approved'];
            }

            if($leaveRequest->is_approved) { /*reset remaining leave and leave taken first*/
                $resetRemainingDays = $this->EmpLeaves->resetLeaveDaysAfterApprovedHRChanges($leaveRequest, $employeePreviousLeaveType);
            }

            $LeaveRequestsForm = $this->EmpLeaves->convertStringtoDateFormat($LeaveRequestsForm);
            $leaveRequest = $this->EmpLeaves->patchEntity($leaveRequest, $LeaveRequestsForm);

            $newLeaveType = $leaveRequest->leave_type;

            $selectedReliever = $LeaveRequestsForm['list'];

            $cnt = 0;
            foreach ($selectedReliever as $r) {
                if($cnt == 0) {
                    $leaveRequest->reliever = ",".$r;
                    $leaveRequest->reliever_name = $this->EmpLeaves->getNameFromId($r);
                }
                else {
                    $leaveRequest->reliever .= ",".$r;
                    $leaveRequest->reliever_name = ",".$this->EmpLeaves->getNameFromId($r);
                }
                $cnt++;
            }

            $reportingManagerId = $this->Auth->user('reporting_manager');
            $reportingManagerEmail = $this->EmpLeaves->reportingManagerEmail($leaveRequest->reporting_managerId);

            if($leaveRequest->is_approved) { // set new remaining leave and leave taken after updating
                $leaveRequest = $this->EmpLeaves->resetUpdateLeaveTaken($leaveRequest);
                $updateRemainingDays = $this->EmpLeaves->updateLeaveDaysAfterApprovedHRChanges($leaveRequest, $newLeaveType);
                $leaveRequest = $this->EmpLeaves->updateLeaveTaken($leaveRequest, $newLeaveType);

                $this->saveEmployeeRequest($leaveRequest, $updateRemainingDays, $reportingManagerEmail, $LeaveRequestsForm);
            }
            else {
                $leaveRequest = $this->EmpLeaves->resetUpdateLeaveTaken($leaveRequest);
                $this->saveEmployeeRequest($leaveRequest, $getLeaveDays, $reportingManagerEmail, $LeaveRequestsForm);
            }
        }
        $employees = $this->EmpLeaves->Employees->find('list', ['limit' => 200]);
        $this->set(compact('leaveRequest','reliever', 'previousSelectedRelieverList', 'employees','employeeOfficeLocation','employeeId','employeeName','employeeReportingManager','employeeType','sick_taken','casual_taken','LWoP_taken','earned_taken','unplanned_taken','planned_taken','remainingUnplannedLeave','remainingPlannedLeave','remainingSickLeave','remainingCasualLeave','remainingEarnedLeave','restricted_taken','remainingRestrictedLeave','totalLeaveTaken','totalLeaveTakenForGoa'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Emp Leave id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function delete($id = null)
    {
        $leaveRequest = $this->EmpLeaves->get($id, [
            'contain' => ['Employees']
            ]
        );
        //Check whether the request has been approved or not. 
        if($leaveRequest['is_approved'] != 1){
            
        $this->request->allowMethod(['post', 'delete']);
            if ($this->EmpLeaves->delete($leaveRequest)) {
                $this->Flash->success(__('The leave request has been deleted.'));
            } else {
                $this->Flash->error(__('The leave request could not be deleted. Please, try again.'));
            }
        } else {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $updateRemainingDays = $this->EmpLeaves->updateLeaveDays($leaveRequest);
                $leaveRequestForm = $this->EmpLeaves->isCancelled($leaveRequest); 
                $applierEmail = $leaveRequest->employee->office_email;
                if ($this->EmpLeaves->save($leaveRequest)) {
                    $this->Flash->success(__('The leave request has been reverted.'));
                    $emailTo = array();
                    $emailTo[] = $applierEmail;
                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto($emailTo)
                        ->setcc('hr@managedcoder.com')
                        ->setemailFormat('html')
                        ->setTemplate('lr_cancelled')
                        ->setsubject($leaveRequest->employee_name.', Your Leave has been Cancelled #' . rand(108512, 709651))
                        ->setViewVars(['applierName' => $leaveRequest->employee_name, 'date_from' => $leaveRequest->date_from, 'date_to' => $leaveRequest->date_to, 'leaveReason' => $leaveRequest->leave_reason, 'reliever' => $leaveRequest->reliever_name, 'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png', 'leaveId' => $leaveRequest->id, 'leaveType' => $this->EmpLeaves->getLeaveTypeByLeaveId($leaveRequest->leaveType), 'noOfDays' => $leaveRequest->no_of_days])
                        ->send();
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The leave request could not be reverted. Please, try again.'));
            } 
        }
        return $this->redirect(['action' => 'index']);
    }    

    // check for approval
    public function approve($isApprove = null, $ids = null, $employee_id = null, $leaveType = null, $halfDay = null)
    {
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $getLeaveDays = $this->EmpLeaves->totalLeaveData($employee_id);
        $dateAndDays=$this->EmpLeaves->find()->select(['min_date'=>'min(date_from)','max_date'=>'max(date_to)','no_of_days'=>'sum(no_of_days)'])->where('EmpLeaves.id in ('.$ids.')')->toList();
        $dateAndDays=$dateAndDays[0];
        $idArray=explode(",",$ids);
        foreach($idArray as $index=> $id) {
                
                $leaveRequest = $this->EmpLeaves->get($id, ['contain' => ['Employees'] ]);
                $noOfDays = $this->EmpLeaves->get($id);
                $numberOfDays=$noOfDays->no_of_days;
                $officeLocation = $leaveRequest->employee->office_location;
                
                if($isApprove == 1 && ($leaveType == 1 || $leaveType == 2 ||$leaveType == 3 ||$leaveType == 4 ||$leaveType == 5 ||$leaveType == 6 ||$leaveType == 7 ||$leaveType == 8)) {
                    $CheckApprovalDecision = $this->EmpLeaves->isFullApproved($leaveRequest, $isApprove, $leaveType, $employeeName, $getLeaveDays);
                    $CheckApprovalDecisionCalculation = $this->EmpLeaves->remainingCalculateFull($CheckApprovalDecision,$getLeaveDays);
                }

                switch($leaveType){
                    case 1:{ $remainingLeave=$getLeaveDays['sick_leave'] ; break; }
                    case 2:{ $remainingLeave=$getLeaveDays['casual_leave']; break; }
                    case 3:{ break; }
                    case 4:{ $remainingLeave=$getLeaveDays['earned_leave'];  break; }
                    case 5:{ $remainingLeave=$getLeaveDays['unplanned_leave']; break; }
                    case 6:{ $remainingLeave=$getLeaveDays['planned_leave']; break; }
                    case 7:{ $remainingLeave=$getLeaveDays['restricted_leave'];  break; }
                }
                if($numberOfDays<=$remainingLeave || $leaveType==3)
                {
                    $UpdateRemainingLeave = $this->EmpLeaves->updateRemainingLeaves($CheckApprovalDecisionCalculation);
                    if($isApprove == 1 && $UpdateRemainingLeave == true) {
                        $nowTime = date('Y-m-d');
                        $CheckApprovalDecision['approved_or_rejected'] = $nowTime;
                        if($this->EmpLeaves->save($CheckApprovalDecision)) {
                                if($index==0)
                                {
                                    $approverEmail = $this->Auth->user('office_email');
                                    $applierEmail = $CheckApprovalDecision->employee['office_email'];
                                    $employeeReportingManagerEmail = $this->EmpLeaves->reportingManagerEmail($leaveRequest->reporting_managerId);
                                    $emailTo = array();
                                    $emailTo[] = $applierEmail;
                                    $email = new Email();
                                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                                        ->setto($emailTo)
                                        ->setcc('hr@managedcoder.com')
                                        ->setemailFormat('html')
                                        ->setTemplate('lr_approve')                                                                                                                 
                                        ->setsubject($CheckApprovalDecision->employee['first_name'] . ' ' . $CheckApprovalDecision->employee['last_name'] . ', Your Leave has been Approved #' . rand(108512, 709651))
                                        ->setViewVars(['applierName' => $CheckApprovalDecision->employee['first_name'] . ' ' . $CheckApprovalDecision->employee['last_name'], 'date_from' => $dateAndDays['min_date'], 'date_to' => $dateAndDays['max_date'], 'leave_reason' => $noOfDays['leave_reason'], 'reliever' => $noOfDays['reliever_name'], 'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png', 'leaveId' => $leaveRequest->id, 'leaveType' => $this->EmpLeaves->getLeaveTypeByLeaveId($leaveType), 'noOfDays' => $dateAndDays['no_of_days']])
                                        ->send();
                                }

                            if ($leaveRequest->leave_type == 5) {
                                $this->EmpLeaves->sendNotificationForUnplannedLeaveTakenMoreThanThreeDays($leaveRequest, $getLeaveDays);
                            }

                            switch($leaveType){
                                case 1:{ $remainingLeave=$UpdateRemainingLeave->sick_leave ; break; }
                                case 2:{ $remainingLeave=$UpdateRemainingLeave->casual_leave; break; }
                                case 3:{ break; }
                                case 4:{ $remainingLeave=$UpdateRemainingLeave->earned_leave;  break; }
                                case 5:{ $remainingLeave=$UpdateRemainingLeave->unplanned_leave; break; }
                                case 6:{  $remainingLeave=$UpdateRemainingLeave->planned_leave; break; }
                                case 7:{  $remainingLeave=$UpdateRemainingLeave->restricted_leave;  break; }
                            }

                            if(($remainingLeave<=0)||($leaveRequest->lwop_leave_taken >= 20)) {
                                $this->EmpLeaves->sendNotificationWhenAnyLeaveRemainingIsZero($UpdateRemainingLeave->sick_leave,
                                    $UpdateRemainingLeave->casual_leave, $UpdateRemainingLeave->earned_leave, $UpdateRemainingLeave->planned_leave,
                                    $UpdateRemainingLeave->unplanned_leave, $UpdateRemainingLeave->restricted_leave, $leaveRequest->lwop_leave_taken, $leaveRequest, $officeLocation);
                            }
                           
                        } else {
                            $this->Flash->error(__('The leave request has been Declined.'));
                            return $this->redirect(['action' => 'index']);
                            }
                        }else {
                          $this->Flash->error(__('The leave request could not be processed. Please, try again.'));
                          return $this->redirect(['action' => 'index']);
                        }
                }else{
                        $this->Flash->error(__('The leave request cannot be approved as number of days the leave is requested is less then the available number of days in leave balance.'));
                        return $this->redirect(['action' => 'index']);
                }
        }
        $this->Flash->success(__('The leave request has been Approved.'));
        return $this->redirect(['action' => 'index']);
    }

    // add reject reason
    public function rejectReason($isApprove = null, $ids = null,$employee_id = null,$leaveType = null, $halfDay = null)
    {
        $this->autoRender=false;
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');        
        $idArray=explode(",",$ids);
        $dateAndDays=$this->EmpLeaves->find()->select(['min_date'=>'min(date_from)','max_date'=>'max(date_to)','no_of_days'=>'sum(no_of_days)'])->where('EmpLeaves.id in ('.$ids.')')->toList();
        $dateAndDays=$dateAndDays[0];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rejectReason = $this->request->getData();
                foreach($idArray as $index => $id) {
                        $leaveRequest = $this->EmpLeaves->get($id,['contain' => ['Employees']]);
                        $noOfDays = $this->EmpLeaves->get($id);
                        if(($isApprove == 1 || $isApprove == 2) && ($leaveType == 1 || $leaveType == 2 ||$leaveType == 3 ||$leaveType == 4 ||$leaveType == 5 ||$leaveType == 6) && $halfDay == 0 ){
                            $CheckApprovalDecision = $this->EmpLeaves->isFullApproved($leaveRequest,$isApprove,$leaveType,$employeeName, $noOfDays);
                        }
                        if(($isApprove == 1 || $isApprove == 2) && ($leaveType == 1 || $leaveType == 2 ||$leaveType == 3 ||$leaveType == 4 ||$leaveType == 5 ||$leaveType == 6) &&$halfDay > 0){
                            $CheckApprovalDecision = $this->EmpLeaves->isHalfApproved($leaveRequest,$leaveType,$isApprove,$halfDay,$employeeName);
                        }  
                        
                        $CheckApprovalDecision['reject_reason'] = $rejectReason['reject_reason'];
                        $CheckApprovalDecision['is_approved'] = $rejectReason['is_approved'];
                        $CheckApprovalDecision['approved_by'] = $rejectReason['approved_by'];
                        $leaveRequest = $this->EmpLeaves->patchEntity($leaveRequest,$rejectReason);
                        
                        if ($this->EmpLeaves->save($leaveRequest)) {
                            $employees = TableRegistry::get('Employees');
                            $applicant = $employees->get($rejectReason['applicant']);
                            $approverEmail = $this->Auth->user('office_email');
                            $emailTo = array();
                            $emailTo[] = $applicant->office_email;

                            if($index==0)
                            {  
                                $email = new Email();
                                $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                                ->setto($emailTo)
                                ->setcc('hr@managedcoder.com')
                                ->setemailFormat('html')
                                ->setTemplate('lr_denied')
                                ->setsubject($applicant->first_name . ' ' . $applicant->last_name.', Your Leave has been Denied #' . rand(108512, 709651))
                                ->setViewVars(['applierName' => $applicant->first_name . ' ' . $applicant->last_name, 'date_from' => $dateAndDays['min_date'], 'date_to' => $dateAndDays['max_date'], 'leave_reason' => $rejectReason['leave_reason'], 'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png', 'leaveId' => $leaveRequest->id, 'leaveType' => $this->EmpLeaves->getLeaveTypeByLeaveId($leaveType), 'noOfDays' => $dateAndDays['no_of_days'], 'leaveReason' => $CheckApprovalDecision['reject_reason']])
                                ->send('Your leave request has been Rejected. Reason: ' . $CheckApprovalDecision['reject_reason']);
                            }
                        }else {
                            $this->Flash->error(__('The leave request could not be rejected. Please, try again.'));
                            return $this->redirect(['action' => 'index']);
                        }
                }
            $this->Flash->success(__('The leave request has been rejected.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    // for showing pending requests
    public function pending()
    {

        $this->paginate = [
            'contain' =>    ['Employees']
        ];

        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $reportingManagerId = $this->Auth->user('reporting_manager');
        $listForReportingManager = $this->EmpLeaves->find()->WHERE(['reporting_managerId' => $employeeId])->WHERE(['is_approved'=> 0])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation'=> 0]);

        if($roleId == 2){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['is_approved' => 0])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation'=> 0]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } elseif (!empty($listForReportingManager)){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['OR'=>['employee_id'=>$employeeId,'reporting_managerId'=>$employeeId]])->WHERE(['is_approved'=>0])->WHERE(['status'=>1])->WHERE(['emp_leave_cancellation'=> 0]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } else {

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['employee_id' => $employeeId ])->WHERE(['is_approved'=> 0])->WHERE(['status' => 0])->WHERE(['emp_leave_cancellation'=> 0]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }

        //for search functionality code from the leave list
        
        $this->loadModel('Employees');
        $employees = $this->Employees->find('list', [
            'keyField' => 'first_name',
            'valueField' => function ($e) {
                return $e->first_name . ' ' . $e->last_name;
            },
            array(
                'order' => array('("first_name") ASC')
        )]
        );

        $employees = $employees->toArray();

        $employees[''] = 'Select Employee';

        $keywordSearch = $this->request->getQuery('keywordPending');
        if (!empty($keywordSearch)) 
        {
            $leaveRequests = $this->EmpLeaves->find()
            ->where(
            ['employee_name LIKE' => '%' .$keywordSearch. '%']
            )->WHERE(['is_approved' => 0])->WHERE(['emp_leave_cancellation'=> 0]);
            $leaveRequests = $this->paginate($leaveRequests);
        }

        $branch = '';
        $this->set(compact('leaveRequests', 'roleId', 'branch', 'employees'));
    }

    // for showing approved requests
    public function approved()
    {

        $this->paginate = [
            'contain' =>    ['Employees']
        ];
        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $reportingManagerId = $this->Auth->user('reporting_manager');
        $listForReportingManager = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['reporting_managerId' => $reportingManagerId ])->WHERE(['is_approved'=> 1])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation' => 0]);
        if($roleId == 2){

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['is_approved'=> 1])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation' => 0]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } elseif (!empty($listForReportingManager)){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['OR'=>['employee_id'=>$employeeId,'reporting_managerId'=>$employeeId]])->WHERE(['is_approved'=>1])->WHERE(['status'=>1])->WHERE(['emp_leave_cancellation' => 0]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }  else {

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['employee_id' => $employeeId ])->WHERE(['is_approved'=> 1])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation' => 0]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }

        //for search functionality code from the leave list
        
        $this->loadModel('Employees');
        $employees = $this->Employees->find('list', [
            'keyField' => 'first_name',
            'valueField' => function ($e) {
                return $e->first_name . ' ' . $e->last_name;
            },
            array(
                'order' => array('("first_name") ASC')
        )]
        );

        $employees = $employees->toArray();

        $employees[''] = 'Select Employee';

        $keywordSearch = $this->request->getQuery('keywordApproved');
        if (!empty($keywordSearch)) 
        {
            $leaveRequests = $this->EmpLeaves->find()
            ->where(
            ['employee_name LIKE' => '%' .$keywordSearch. '%']
            )->WHERE(['is_approved' => 1])->WHERE(['emp_leave_cancellation'=> 0]);
            $leaveRequests = $this->paginate($leaveRequests);
        }

        $branch = '';
        $this->set(compact('leaveRequests','roleId','branch','employees'));
    }

    // for showing rejected requests
    public function rejected()
    {

        $this->paginate = [
            'contain' =>    ['Employees']
        ];
        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $reportingManagerId = $this->Auth->user('reporting_manager');
        $listForReportingManager = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['reporting_managerId' => $reportingManagerId ])->WHERE(['is_approved'=> 2])->WHERE(['status' => 1]);
        $branch = '';
        if($roleId == 2){

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['is_approved'=> 2])->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } elseif (!empty($listForReportingManager)){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['OR'=>['employee_id'=>$employeeId,'reporting_managerId'=>$employeeId]])->WHERE(['is_approved'=>2])->WHERE(['status'=>1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }  else {
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['employee_id' => $employeeId ])->WHERE(['is_approved'=> 2])->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }            
        }

        //for search functionality code from the leave list
        
        $this->loadModel('Employees');
        $employees = $this->Employees->find('list', [
            'keyField' => 'first_name',
            'valueField' => function ($e) {
                return $e->first_name . ' ' . $e->last_name;
            },
            array(
                'order' => array('("first_name") ASC')
        )]
        );

        $employees = $employees->toArray();

        $employees[''] = 'Select Employee';

        $keywordSearch = $this->request->getQuery('keywordRejected');
        if (!empty($keywordSearch)) 
        {
            $leaveRequests = $this->EmpLeaves->find()
            ->where(
            ['employee_name LIKE' => '%' .$keywordSearch. '%']
            )->WHERE(['is_approved' => 2])->WHERE(['emp_leave_cancellation'=> 0]);
            $leaveRequests = $this->paginate($leaveRequests);
        }

        $this->set(compact('leaveRequests','roleId', 'branch','employees'));
    }

    public function leaveReport()
    {
        $this->loadModel('Employees');
        $employees = $this->Employees->find('list', [
            'keyField' => 'id',
            'valueField' => function ($e) {
                return $e->first_name . ' ' . $e->last_name;
            },
            array(
                'order' => array('("first_name") ASC')
        )]
        );

        $employees = $employees->toArray();
        $employees[''] = 'Select Employee';
        $this->set(compact('employees'));

        $this->set(compact('employees'));
    }

    public function branchLeaveReport()
    {
        // don't delete these method
    }

    public function getLeaveType()
    {
        if ($this->request->is('post')) {
            $this->loadModel('Employees');
            $formData = $this->request->getData();
            $employee = $this->Employees->get($formData['empId']);
            $employeeOfficeLocation = $employee->office_location;
            $employeeType = $employee->employment_type;
            $this->set(compact('employeeOfficeLocation', 'employeeType'));

        }
    }

    public function getBranchwiseLeaveType()
    {
        if ($this->request->is('post')) {
            $postData = $this->request->getData();
            $employeeOfficeLocation = $postData['officeLocation'];
            $employeeType = '';
            $this->set(compact('employeeOfficeLocation', 'employeeType'));
        }
    }

    public function getFilteredLeavesForPdf() {
        $employees="";
        $dateFrom = $this->request->query(["dateFrom"]);
        $dateTo = $this->request->query(["dateTo"]);
        $empId = $this->request->query(["empId"]);
        $leaveType = $this->request->query(["leaveType"]);

        if (!empty($dateFrom)) {
            $roleId = $this->Auth->user('role_id');
            $branch = '';
            if($leaveType == ''){
                $LeaveRequests = $this->EmpLeaves->find('all')
                    ->WHERE(['employee_id' => $empId ])
                    ->WHERE(['date_from >=' => date_format(date_create($dateFrom), 'Y-m-d H:i:s')])
                    ->WHERE(['date_to <=' => date_format(date_create($dateTo), 'Y-m-d H:i:s')])
                    ->contain('Employees')->where(['Employees.employment_status'=>1]);

            } else {
                $LeaveRequests = $this->EmpLeaves->find('all')
                    ->WHERE(['employee_id' => $empId ])
                    ->WHERE(['leave_type'=> $leaveType])
                    ->WHERE(['date_from >=' => date_format(date_create($dateFrom), 'Y-m-d H:i:s')])
                    ->WHERE(['date_to <=' => date_format(date_create($dateTo), 'Y-m-d H:i:s')])
                    ->contain('Employees')->where(['Employees.employment_status'=>1]);
            }
            $leaveRequests = $LeaveRequests;
        }
        $this->set(compact('leaveRequests','roleId','branch','employees', 'dateFrom', 'dateTo', 'empId', 'leaveType'));
    }

    public function getBranchFilteredLeavesForPdf() {
        $dateFrom = $this->request->query(["dateFrom"]);
        $dateTo = $this->request->query(["dateTo"]);
        $branch = $this->request->query(["branch"]);
        $leaveType = $this->request->query(["leaveType"]);

        if (!empty($dateFrom)) {
            $roleId = $this->Auth->user('role_id');
            if($leaveType == ''){
                $LeaveRequests = $this->EmpLeaves->find('all')
                    ->WHERE(['Employees.office_location' => $branch])
                    ->WHERE(['date_from >=' => date_format(date_create($dateFrom), 'Y-m-d H:i:s')])
                    ->WHERE(['date_to <=' => date_format(date_create($dateTo), 'Y-m-d H:i:s')])
                    ->contain('Employees')->where(['Employees.employment_status'=>1]);
            } else {
                $LeaveRequests = $this->EmpLeaves->find('all')
                    ->WHERE(['Employees.office_location' => $branch])
                    ->WHERE(['leave_type'=> $leaveType])
                    ->WHERE(['date_from >=' => date_format(date_create($dateFrom), 'Y-m-d H:i:s')])
                    ->WHERE(['date_to <=' => date_format(date_create($dateTo), 'Y-m-d H:i:s')])
                    ->contain('Employees')->where(['Employees.employment_status'=>1]);
            }
            $leaveRequests = $LeaveRequests;
        }
        $this->set(compact('leaveRequests','roleId', 'branch', 'dateFrom', 'dateTo', 'leaveType'));
    }

    public function getFilteredLeaves()
    {
        $dateFrom = $this->request->query(["dateFrom"]);
        $dateTo = $this->request->query(["dateTo"]);
        $empId = $this->request->query(["empId"]);
        $leaveType = $this->request->query(["leaveType"]);

        if (!empty($dateFrom)) {
            $roleId = $this->Auth->user('role_id');
            $branch = '';

            if($leaveType == ''){
                $LeaveRequests = $this->EmpLeaves->find('all')
                    ->WHERE(['employee_id' => $empId ])
                    ->WHERE(['date_from >=' => date_format(date_create($dateFrom), 'Y-m-d H:i:s')])
                    ->WHERE(['date_to <=' => date_format(date_create($dateTo), 'Y-m-d H:i:s')])
                    ->contain('Employees')->where(['employment_status'=>1]);
            } else {
                $LeaveRequests = $this->EmpLeaves->find('all')
                    ->WHERE(['employee_id' => $empId ])
                    ->WHERE(['leave_type'=> $leaveType])
                    ->WHERE(['date_from >=' => date_format(date_create($dateFrom), 'Y-m-d H:i:s')])
                    ->WHERE(['date_to <=' => date_format(date_create($dateTo), 'Y-m-d H:i:s')])
                    ->contain('Employees')->where(['employment_status'=>1]); 
            }
            $leaveRequests = $this->paginate($LeaveRequests);
         }

        $this->set(compact('leaveRequests','roleId','branch', 'dateFrom', 'dateTo', 'empId', 'leaveType'));
    }

    public function getBranchwiseFilteredLeaves()
    {
        $dateFrom = $this->request->query(["dateFrom"]);
        $dateTo = $this->request->query(["dateTo"]);
        $branch = $this->request->query(["branch"]);
        $leaveType = $this->request->query(["leaveType"]);

        if (!empty($dateFrom)) {
            $roleId = $this->Auth->user('role_id');

            if($leaveType == ''){
                $LeaveRequests = $this->EmpLeaves->find('all')
                    ->WHERE(['Employees.office_location' => $branch])
                    ->WHERE(['date_from >=' => date_format(date_create($dateFrom), 'Y-m-d H:i:s')])
                    ->WHERE(['date_to <=' => date_format(date_create($dateTo), 'Y-m-d H:i:s')])
                    ->contain('Employees')->where(['Employees.employment_status'=>1]);
            } else {
                $LeaveRequests = $this->EmpLeaves->find('all')
                    ->WHERE(['Employees.office_location' => $branch])
                    ->WHERE(['leave_type'=> $leaveType])
                    ->WHERE(['date_from >=' => date_format(date_create($dateFrom), 'Y-m-d H:i:s')])
                    ->WHERE(['date_to <=' => date_format(date_create($dateTo), 'Y-m-d H:i:s')])
                    ->contain('Employees')->where(['Employees.employment_status'=>1]);
            }
            $leaveRequests = $this->paginate($LeaveRequests);
            $this->set(compact('leaveRequests','roleId', 'branch', 'dateFrom', 'dateTo', 'leaveType'));
        }
    }

    public function downloadLeaveReport($dateFrom, $dateTo, $empId, $leaveType, $fileType)
    {
        $dateTo = new \DateTime(str_replace('-', "/", $dateTo));
        $dateFrom = new \DateTime(str_replace('-', "/", $dateFrom));

        if($leaveType == 'all') {

            $leaves = $this->EmpLeaves->find('all')
                ->WHERE(['employee_id' => $empId ])
                ->WHERE(['date_from >=' => $dateFrom->format('Y-m-d H:i:s')])
                ->WHERE(['date_to <=' => $dateTo->format('Y-m-d H:i:s')])
                ->contain('Employees')->where(['Employees.employment_status'=>1]);

            if($fileType == 'csv'){
                $this->ExportCode->exportCsvReport($leaves);
            } else if ($fileType == 'xls'){
                $this->ExportCode->exportExcelReport($leaves);
            }
        }

        else {
            $leaves = $this->EmpLeaves->find('all')
                ->WHERE(['employee_id' => $empId ])
                ->WHERE(['leave_type'=> $leaveType])
                ->WHERE(['date_from >=' => $dateFrom->format('Y-m-d H:i:s')])
                ->WHERE(['date_to <=' => $dateTo->format('Y-m-d H:i:s')])
                ->contain('Employees')->where(['Employees.employment_status'=>1]);

            if($fileType == 'csv'){
                $this->ExportCode->exportCsvReport($leaves);
            } else if ($fileType == 'xls'){
                $this->ExportCode->exportExcelReport($leaves);
            }
        }

        die;
    }


    public function downloadBranchwiseLeaveReport($dateFrom, $dateTo, $branchId, $leaveType, $fileType)
    {
        $dateTo = new \DateTime(str_replace('-', "/", $dateTo));
        $dateFrom = new \DateTime(str_replace('-', "/", $dateFrom));

        if($leaveType == 'all') {

            $leaves = $this->EmpLeaves->find('all')
                ->contain('Employees')
                ->WHERE(['Employees.office_location' => $branchId,'Employees.employment_status'=>1])
                ->WHERE(['date_from >=' => $dateFrom->format('Y-m-d H:i:s')])
                ->WHERE(['date_to <=' => $dateTo->format('Y-m-d H:i:s')]);
            if($fileType == 'csv'){
                $this->ExportCode->exportCsvReport($leaves);

            } else if ($fileType == 'xls'){
                $this->ExportCode->exportExcelReport($leaves);
            }
        }

        else {
            $leaves = $this->EmpLeaves->find('all')
                ->contain('Employees')
                ->WHERE(['Employees.office_location' => $branchId,'Employees.employment_status'=>1 ])
                ->WHERE(['leave_type'=> $leaveType])
                ->WHERE(['date_from >=' => $dateFrom->format('Y-m-d H:i:s')])
                ->WHERE(['date_to <=' => $dateTo->format('Y-m-d H:i:s')]);
            if($fileType == 'csv'){
                $this->ExportCode->exportCsvReport($leaves);

            } else if ($fileType == 'xls'){
                $this->ExportCode->exportExcelReport($leaves);
            }
        }
        return $this->response->withType('application/json')->withStringBody(json_encode(['code' => '1']));
 
    }

    //Employee Leve Cancelation Method

    public function employeesLeaveCancellation($id = null)
    {
        $leaveRequest = $this->EmpLeaves->get($id, [
            'contain' => ['Employees']
            ]);

        $employeeId = $this->Auth->user('id');
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $employeeReportingManager = $this->Auth->user('reporting_manager');
        $employeeType = $this->Auth->user('employment_type');
        $employeeOfficeLocation = $this->Auth->user('office_location');

        $reportingManagerId = $this->Auth->user('reporting_manager');
        $reportingManagerEmail = $this->EmpLeaves->reportingManagerEmail($reportingManagerId);

        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,4);
        if(in_array($loggedUser, $role))
        {
            $employeesLeaveCancellation = $this->EmpLeaves->get($id);
            $employee_name = $employeesLeaveCancellation->employee_name;
            $no_of_days = $employeesLeaveCancellation->no_of_days;
            $dateFrom = $employeesLeaveCancellation->date_from;
            $dateTo = $employeesLeaveCancellation->date_to;
            $leave_type =  $this->EmpLeaves->getLeaveTypeByLeaveId($employeesLeaveCancellation->leave_type);
            $reliever_name = $employeesLeaveCancellation->reliever_name;
            $employeesLeaveCancellation->emp_leave_cancellation = 1;
            $employeeLeaveID = $employeesLeaveCancellation->id;

            $backup_is_approved =  $employeesLeaveCancellation->is_approved;

            if($loggedUser == 2) {
                $employeesLeaveCancellation->is_approved = 2;
            }

            $nowTime = date('Y-m-d');
            $employeesLeaveCancellation['approved_or_rejected'] = $nowTime;

            if($this->EmpLeaves->save($employeesLeaveCancellation))
            {
                if($loggedUser == 2 && $backup_is_approved == 1)
                {
                    $updateRemainingDays = $this->EmpLeaves->updateLeaveDays($leaveRequest);
                    $leaveRequestForm = $this->EmpLeaves->isCancelled($leaveRequest);
                }
                $applierEmail = $this->Auth->user('office_email');
                $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

                $emailTo = array();
                $emailTo[] = $reportingManagerEmail;

                if($reportingManagerEmail != null) {
                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto($emailTo)
                        ->setCc('hr@managedcoder.com')
                        ->setemailFormat('html')
                        ->setTemplate('cancel_leave')
                        ->setsubject($applierName . ' Cancelled The Leave Report' . rand(108512, 709651))
                        ->setViewVars(['applierName' => $applierName,
                            'employee_name' => $employee_name,
                            'office_email' => $applierEmail,
                            'no_of_days' => $no_of_days,
                            'dateFrom' => $dateFrom,
                            'dateTo' => $dateTo,
                            'leave_type' => $leave_type,
                            'reliever_name' => $reliever_name])
                        ->send();
                } else {
                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto('hr@managedcoder.com')
                        ->setemailFormat('html')
                        ->setTemplate('cancel_leave')
                        ->setsubject($applierName . ' Cancelled The Leave Report' . rand(108512, 709651))
                        ->setViewVars(['applierName' => $applierName,
                            'employee_name' => $employee_name,
                            'office_email' => $applierEmail,
                            'no_of_days' => $no_of_days,
                            'dateFrom' => $dateFrom,
                            'dateTo' => $dateTo,
                            'leave_type' => $leave_type,
                            'reliever_name' => $reliever_name])
                        ->send();
                }
                $this->Flash->success(__('The request have beed cancelled.'));
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

    //Cancelled leave list

    public function cancelledleaveslist()
    {
         $this->paginate = [
            'contain' =>    ['Employees']
        ];
        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $reportingManagerId = $this->Auth->user('reporting_manager');
        $listForReportingManager = $this->EmpLeaves->find()->WHERE(['reporting_managerId' => $reportingManagerId ])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation' => 1]);
        if($roleId == 2){

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } elseif (!empty($listForReportingManager)){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['OR'=>['employee_id'=>$employeeId,'reporting_managerId'=>$employeeId]])->WHERE(['status'=>1])->WHERE(['emp_leave_cancellation' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }  else {

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->EmpLeaves->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->EmpLeaves->find('all',['order' => ['EmpLeaves.id' => 'desc']])->WHERE(['employee_id' => $employeeId ])->WHERE(['status' => 1])->WHERE(['emp_leave_cancellation' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }

        //for search functionality code from the leave list
        
        $this->loadModel('Employees');
        $employees = $this->Employees->find('list', [
            'keyField' => 'first_name',
            'valueField' => function ($e) {
                return $e->first_name . ' ' . $e->last_name;
            },
            array(
                'order' => array('("first_name") ASC')
        )]
        );
        $employees = $employees->toArray();
        $employees[''] = 'Select Employee';
        $keywordSearch = $this->request->getQuery('keywordCancelled');
        if (!empty($keywordSearch)) 
        {
            $leaveRequests = $this->EmpLeaves->find()
            ->where(
            ['employee_name LIKE' => '%' .$keywordSearch. '%']
            )->WHERE(['emp_leave_cancellation'=> 1]);
            $leaveRequests = $this->paginate($leaveRequests);
        }
        $branch = '';
        $this->set(compact('leaveRequests','roleId','branch','employees'));
    }
    
    public function relieverAssignee()
    {
        $this->loadModel('Employees');

        $this->paginate = [
            'contain' =>    ['Employees']
        ];
        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $reportingManagerId = $this->Auth->user('reporting_manager');

        $loggedUserName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

        $leaveRequestData = $this->EmpLeaves->find('all');
        $leaveRequests=$leaveRequestData
                        ->select($this->EmpLeaves)
                        ->select(['min_date'=>$leaveRequestData->func()->min('date_from'),
                                  'max_date'=>$leaveRequestData->func()->max('date_to'),
                                  'number_of_days'=>$leaveRequestData->func()->count('no_of_days'),
                                  'reliever_name'=>$leaveRequestData->func()->max('reliever_name'),
                                  'ids'=>'group_concat(EmpLeaves.id)',
                                ])
                        ->WHERE(['reliever_status' => 0, 'reliever like' => '%'.$employeeId."%"])
                        ->group(['leave_reason','date(EmpLeaves.created)','leave_type'])
                        ->order(['EmpLeaves.id' => 'desc']);
        $leaveRequests = $this->paginate($leaveRequests);
        $branch = "";

        $this->set(compact('leaveRequests','roleId', 'employeeId', 'branch'));
    }
    public function relieverResponsForLeaveApprove($idString = null)
    {
        $ids=explode(",",$idString);     
        $employeeId = $this->Auth->user('id');
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $employeeReportingManager = $this->Auth->user('reporting_manager');
        $employeeType = $this->Auth->user('employment_type');
        $employeeOfficeLocation = $this->Auth->user('office_location');
        $reportingManagerId = $this->Auth->user('reporting_manager');
        $reportingManagerEmail = $this->EmpLeaves->reportingManagerEmail($reportingManagerId);

        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,4);
        
        if(in_array($loggedUser, $role))
        {
            $allLeaves=$this->EmpLeaves->find();
            $leaveRequestFrom="";
            foreach($ids as $key => $id)
            {
                $leaveRequest = $this->EmpLeaves->get($id, ['contain' => ['Employees']]);
                $emailOfRequestedEmployee = $leaveRequest->employee->office_email;
                $approveRelieverRequest = $this->EmpLeaves->get($id);
                $employee_name = $approveRelieverRequest->employee_name;
                $no_of_days = $approveRelieverRequest->no_of_days;
                $dateFrom = $approveRelieverRequest->date_from;
                $employee_id = $approveRelieverRequest->employee_id;
                $leaveReason=$approveRelieverRequest->leave_reason;
                $dateTo = $approveRelieverRequest->date_to;
                $leave_type =  $this->EmpLeaves->getLeaveTypeByLeaveId($approveRelieverRequest->leave_type);
                
                $reliever_name = $approveRelieverRequest->reliever_name;
               
                if($approveRelieverRequest->reliever_approved == 0) {
                    $approveRelieverRequest->reliever_approved = ",".$employeeId;
                } else {
                    $approveRelieverRequest->reliever_approved .= ",".$employeeId;
                }
                $isMailSent=$allLeaves->where(['id in '=>$idString,'reliever_approved !='=>'0'])->toArray();
                if(empty($isMailSent))
                {
                    $sendmail=true;
                }

                 $employeeLeaveID = $approveRelieverRequest->id;
                if($this->EmpLeaves->save($approveRelieverRequest))
                {
                    $applierEmail = $this->Auth->user('office_email');
                    $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

                    $emailTo = array();
                    $emailTo[] = $emailOfRequestedEmployee;

                    if($sendmail)
                    {
                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto($emailTo)
                        ->setemailFormat('html')
                        ->setTemplate('approve_reliver_request')
                        ->setsubject($applierName . ' approved the reliever request of '.$employee_name. rand(108512, 709651))
                        ->setViewVars(['applierName' => $applierName,
                            'employee_name' => $employee_name,
                            'office_email' => $applierEmail,
                            'no_of_days' => count($ids),
                            'dateFrom' => $dateFrom,
                            'dateTo' => $dateTo,
                            'leave_type' => $leave_type,
                            'leaveRequestFrom'=>$leaveRequestFrom,
                            'reliever_name' => $approveRelieverRequest->reliever_approved])
                        ->send();
                        $sendmail=false;
                    }
                }
                else {
                    $this->Flash->error(__('This request could not be accept.'));
                }
            }
            $this->Flash->success(__('The request have beed accepted.'));
            return $this->redirect(['action' => 'relieverAssignee']);
        }
        else {
            return $this->redirect(['action' => 'relieverAssignee']);
        }
    }


    public function relieverResponsForLeaveReject($idString = null) {
        $ids=explode(",",$idString);
        $employeeId = $this->Auth->user('id');
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $employeeReportingManager = $this->Auth->user('reporting_manager');
        $employeeType = $this->Auth->user('employment_type');
        $employeeOfficeLocation = $this->Auth->user('office_location');

        $reportingManagerId = $this->Auth->user('reporting_manager');
        $reportingManagerEmail = $this->EmpLeaves->reportingManagerEmail($reportingManagerId);

        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,4);
        if(in_array($loggedUser, $role))
        {
            $allLeaves=$this->EmpLeaves->find();
            $leaveRequestFrom="";
            foreach($ids as $key => $id)
            {
                $leaveRequest = $this->EmpLeaves->get($id, ['contain' => ['Employees']]);
                $emailOfRequestedEmployee = $leaveRequest->employee->office_email;
                $allLeaves=$this->EmpLeaves->find();
                $rejectRelieverRequest = $this->EmpLeaves->get($id);
                $employee_name = $rejectRelieverRequest->employee_name;
                $no_of_days = $rejectRelieverRequest->no_of_days;
                $dateFrom = $rejectRelieverRequest->date_from;
                $dateTo = $rejectRelieverRequest->date_to;
                $leave_type =  $this->EmpLeaves->getLeaveTypeByLeaveId($rejectRelieverRequest->leave_type);
                $reliever_name = $rejectRelieverRequest->reliever_name;
                
                $employee_id = $rejectRelieverRequest->employee_id;
                $leaveReason=$rejectRelieverRequest->leave_reason;
                $employeeLeaveID = $rejectRelieverRequest->id;
                if($rejectRelieverRequest->reliever_rejected == 0) {
                    $rejectRelieverRequest->reliever_rejected = ','.$employeeId;
                } else {
                    $rejectRelieverRequest->reliever_rejected .= ",".$employeeId;
                }
  
                $isMailSent=$allLeaves->where(['id in '=>$idString,'reliever_rejected !='=>'0'])->toArray();
                if(empty($isMailSent))
                {
                    $sendmail=true;
                }

                if($this->EmpLeaves->save($rejectRelieverRequest)) {
                    $applierEmail = $this->Auth->user('office_email');
                    $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
                    $emailTo = array();
                    $emailTo[] = $emailOfRequestedEmployee;
                    if($sendmail)  {
                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto($emailTo)
                        ->setemailFormat('html')
                        ->setTemplate('reject_reliver_request')
                        ->setsubject($applierName . ' rejected for reliever request of '.$employee_name. rand(108512, 709651))
                        ->setViewVars(['applierName' => $applierName,
                            'employee_name' => $employee_name,
                            'office_email' => $applierEmail,
                            'no_of_days' => count($ids),
                            'dateFrom' => $dateFrom,
                            'dateTo' => $dateTo,
                            'leaveRequestFrom'=>$leaveRequestFrom,
                            'leave_type' => $leave_type,
                            'reliever_name' => $rejectRelieverRequest->reliever_rejected])
                        ->send();
                        $sendmail=false;
                    }
                }
                else {
                    $this->Flash->error(__('This leave request could not be rejected '));
                }
            }
            $this->Flash->success(__('The leave request has been rejected.'));
            return $this->redirect(['action' => 'relieverAssignee']);
        }
        else
        {
            return $this->redirect(['action' => 'relieverAssignee']);
        }
    }

    public function sendRequestBeforeReliverDay()
    {
        $this->autoRender = false;
        $nowTime = date('Y-m-d');
        $tomorrow = date("Y-m-d", time() + 86400);
        $reliverFind = $this->EmpLeaves->find('all')->WHERE(['date_from' => $tomorrow,'is_approved'=>1])->contain(['Employees'])->toArray();
        foreach($reliverFind as $key => $reliver)
        {
            $reliverString = trim($reliver['reliever'],",");
            $reliverIds=explode(",",$reliverString);
            $this->loadModel('Employees');
            $results = $this->Employees->find('all')->where(['id IN' => $reliverIds])->toArray();
            //  //set variables:
             $applierName= $reliver['employee_name'];
             $empName    = $reliver['employee_name'];
             $dateFrom   = $reliver['date_from'];
             $dateTo     = $reliver['date_to'];
             $no_of_days = $reliver['no_of_days'];
             $leaveType  = $this->EmpLeaves->getLeaveTypeByLeaveId($reliver['leave_type']);

            foreach($results as $index => $result)
            {
                $name=$result['first_name']." ".$result['last_name'];
                $emailTo["office_email"]=$name;
            }

            if($reliver)
            {
                $subject=$applierName . ' Application for reliver notification #' . rand(108512, 709651);
                $email = new Email();
                $email->setEmailFormat('html');
                $email->setTemplate('send_email_to_reliever_the_day_before');
                $email->setFrom(['connect@sjinnovation.com' => 'SJ Connect']);
                $email->setTo($emailTo);
                $email->setSubject($subject);
                $email->setViewVars( ['applierName' => $applierName,
                                      'first_name' => $empName,
                                      'date_from' => $dateFrom,
                                      'date_to' => $dateTo,
                                      'no_of_days' => $no_of_days,
                                      'leave_type' => $leaveType]);
                $email->send();
            }      
        } 
    }

    private function sendMailToRelivers($relieverDetails,$applierName,$LeaveRequestsfrom,$LeaveRequeststo,$noOfDays,$leaveType)
    {
        $this->autoRender=false;
        $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
        foreach($relieverDetails as $key => $reliever)
        {
            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                ->setto($reliever['email'],$reliever['name'])
                ->setemailFormat('html')
                ->setTemplate('reliever_assigne')
                ->setsubject($applierName.' has requested you to be reliever #' . rand(108512, 709651))
                ->setViewVars(['applierName' => $applierName,
                    'date_from' => $LeaveRequestsfrom,
                    'date_to' => $LeaveRequeststo,
                    'no_of_days'=> $noOfDays,
                    'leave_type'=> $leaveType
                    ])
                ->send();
        }
    }
}

 


