<?php
namespace App\Controller;

use Cake\Event\Event;
use Rest\Utility\JwtToken;
use App\Controller\AppController;
use Rest\Controller\RestController;
use Cake\Mailer\Email;

/**
 * Connect Controller
 *
 *
 * @method \App\Model\Entity\Connect[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConnectController extends RestController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');
    }
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow();
      }

            /**
     * login method
     *
     * @return Response|void
     */
    public function login()
    {
        // you user authentication code will go here, you can compare the user with the database or whatever
        if ($this->request->is('post')) {
            $employee = $this->Auth->identify();
            if ($employee) {
               $success=true;
               $this->Auth->setUser($employee);
               $payload = [
                'email' => $this->request->data('office_email'),
                'password' => $this->request->data('password'),
            ];
    
            $token = \Rest\Utility\JwtToken::generate($payload);
    
            $this->set(compact('token','success'));
            } else {
                $success=false;
            }
        }
        else  $success=false;
        $this->set(compact('success'));
        
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // $bar = [
        //     'falanu' => [
        //         'ameer',
        //         'tamburo'
        //     ]
        // ];

        // $this->set(compact('bar'));
        $connect = $this->paginate($this->Employees);

        $this->set(compact('connect'));
    }

        /**
     * get profile method
     *
     * @return Response|void
     */
    public function getProfile($id){
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,3,4);
        if (in_array($loggedUser, $role)) {
            $employee = $this->Employees->get($id,[
                'contain' => ['Designations', 'Departments','Salary']
            ]);
            
            $reportingTeam= $this->Employees->Departments->getDepartmentById($employee->reporting_team);
            $reportingManager = $this->Employees->getEmployeeById($employee->reporting_manager);

            if(isset($reportingManager) && !empty($reportingManager)) {
                $reportingManager = $reportingManager[0]['first_name'].' '.$reportingManager[0]['last_name'];
            } else {
                $reportingManager = '';
            }
            // dd($employee->salary);
            if(!empty($employee->emp_id)){
                    foreach($employee->emp_id as $salary){
                        $employeeSalary['id']     = $salary['id'];
                        $employeeSalary['salary'] = $salary['salary_amount'];
                        $employeeSalary['approval'] = $salary['is_approved'];
                        $employeeSalary['Reason'] = $salary['reason'];
                    }
            } else {
                $employeeSalary['approval'] = " ";
            }
            $this->set(compact(['success' => true]));
            $this->set(compact('employee', 'reportingTeam', 'reportingManager','employeeSalary'));
        }
        else{
           $this->set(compact(['success' => false]));
        }
    }


    /**
     * Logout method closes the session and redirects to login page
     */
    public function logout()
    {
        ($this->Auth->logout());
    }
    
    public function updateProfile($user){
        
        $employee = $this->Employees->get($user);

        if ($this->request->is(['patch', 'post', 'put'])){

            $employeeFormRequest = $this->request->getData();
            // dd($employeeFormRequest);
            if(!empty($employeeFormRequest['birth_date']))
                $employeeFormRequest = $this->Employees->convertStringtoDateFormatForMember($employeeFormRequest);
            else unset($employeeFormRequest['birth_date']);
            
             if(!empty($this->request->data['profile_pic']['name'])){
                    $fileName =  $this->Employees->uploadPicture($this->request->data['profile_pic']);
                    $employee->profile_pic = $fileName;
                }

            $employee = $this->Employees->patchEntity($employee, $employeeFormRequest);

            //dd($employeeFormRequest);
            if ($this->Employees->save($employee))
            {
                $this->set('success', true);
                $this->Auth->setUser($employee);
                
            }
            else
            {
                $this->set('success', false);
            }
        }
    }

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

        //validation
        $this->loadModel('EmpLeaves');
        $getLeaveDays = $this->EmpLeaves->totalLeaveData($employeeId);

        if($getLeaveDays == null){
            $this->set('success', false);
            $this->set('error', 'No Leave days has been assigned. Please contact with HR.');
            return;         }
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
        if ($this->request->is('post')) 
        {
            $noOfDays=$this->request->getData(['no_of_days']);
            $leaveType=$this->request->getData(['leave_type']);
            $LeaveRequestsForm = $this->request->getData();
            $requestedDateForm = date('Y-m-d', strtotime($this->request->getData(['date_from'])));
            $requestedDateTo = date('Y-m-d', strtotime($this->request->getData(['date_to'])));
            $loggedInUserLeaveRequestWhenPending = $this->EmpLeaves->find('all')->WHERE(['employee_name'=>$loggedUserName, 'date_from' => $requestedDateForm, 'is_approved' => 0])->toArray();
            if($loggedInUserLeaveRequestWhenPending)
            {
                $this->set('success', false);
                $this->set('error', 'You already Apply leave request for this day and leave request is on pending');
                return; 
            }

            $loggedInUserLeaveRequestWhenApproved = $this->EmpLeaves->find('all')->WHERE(['employee_name'=>$loggedUserName, 'date_from' => $requestedDateForm, 'is_approved' => 1])->toArray();
            if($loggedInUserLeaveRequestWhenApproved)
            {
                $this->set('success', false);
                $this->set('error', 'Your leave request has been already approved for this day');
                return; 
                
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
                    foreach($loggedInUserInfo as $loggedInUserInfos)
                    {
                        $loggedInUserDateForm = date('Y-m-d',strtotime($loggedInUserInfos->date_from));
                        $loggedInUserDateTo = date('Y-m-d',strtotime($loggedInUserInfos->date_to));
                        if(($loggedInUserDateForm == $requestedDateForm || $loggedInUserDateTo == $requestedDateTo))
                        {

                            $this->set('success', false);
                            $this->set('error', 'You can not apply for this day, bacause you are the reliever on that day for '.$loggedInUserInfos->employee_name);
                            return; 
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

                            $this->set('success', false);
                            $this->set('error', $this->EmpLeaves->getNameFromId($r)." cannot be assigned as reliever as he/she has already requested leave or has been selected as reliever for this date. Please choose another employee as reliever");
                            return; 
                }
                if($cnt == 0) {
                    $relieverDetails[$cnt]['email']=$this->EmpLeaves->employeeEmail($r);
                    $relieverDetails[$cnt]['name']=$this->EmpLeaves->getNameFromId($r);
                    $leaveRequest->reliever_name =$this->EmpLeaves->getNameFromId($r);
                    $leaveRequest->reliever = ",".$r;
                }
                else {
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
            // $this->set('data',$leaveRequest);
            // return;
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
                    else {
                    
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
                   
                    $this->set('success', true);
                    $this->set('msg', 'Your leave request has been submitted successfully.');
                    return;
                }
             } else if($leaveRequest->no_of_days > 1 && $leaveRequest->no_of_days < 7) {
                for($i = 0 ; $i < $leaveRequest->no_of_days; $i++) {
                    $day = $i. ' day';
                    $var = $this->EmpLeaves->newEntity();
                    if($i == 0) {
                        $var->date_from = date('Y-m-d', strtotime($this->request->getData(['date_from'])));
                        $var->date_to = date('Y-m-d', strtotime($this->request->getData(['date_from'])));
                    }
                    else {
                        $var->date_from = date('Y-m-d', strtotime($day,strtotime($this->request->getData(['date_from']))));
                        $var->date_to = date('Y-m-d', strtotime($day,strtotime($this->request->getData(['date_from']))));
                    }

                    $var->employee_id = $this->Auth->user('id');
                    $var->employee_name = $this->request->getData(['employee_name']);
                    $var->reporting_managerId = $this->request->getData(['reporting_managerId']);
                    $var->leave_type = $this->request->getData(['leave_type']);
                    $var->no_of_days = 1;
                    $var->half_day = $this->request->getData(['half_day']);
                    $var->leave_reason = $this->request->getData(['leave_reason']);
                    $var->reliver = $this->request->getData(['reliever']);
                    //$var->reliever_name = $this->request->getData(['reliever_name']);
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
                else {
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
                    $this->set('success', true);
                    $this->set('msg', 'Your leave request has been submitted successfully');
                    return; 
                    
                }
                else {
                    $this->set('success', false);
                    $this->set('error', 'Your leave has not been submitted,Please check it again and re-submit it.');
                    return; 
                }
        }

        $leaveTypes = [];
        if($employeeOfficeLocation == "SYL" || $employeeOfficeLocation == "DHK" || $employeeOfficeLocation == "NYC"){
            if ($employeeType == "intern"){
                $leaveTypes = [
                    '' => 'Select',
                    '1'=>'Sick Leave'
                ];
                
            } else {
                $leaveTypes = [
                    '' => 'Select',
                    '1'=>'Sick Leave',
                    '2'=>'Casual Leave',
                    '3'=>'LWoP Leave',
                    '4'=>'Earned Leave'
                ];
                  
            }
        } elseif ($employeeOfficeLocation == "GOA") {
            $leaveTypes = [
                '' => 'Select',
                '3' => 'LWoP Leave',
                '5'=>'Un-Planned Leave',
                '6'=>'Planned Leave',
                '7'=>'Restricted Holiday'
            ];
           
        } else {
            $leaveTypes = [
                '' => 'Select',
                '3' => 'LWoP Leave',
                '8'=>'Day Off / vacation'
            ];
           
        }
        $half_day = [
            '0' => 'Select',
            '1'=>'First Half', 
            '2'=>'Second Half'
        ];
        $employees = $this->EmpLeaves->Employees->find('list', ['limit' => 200]);
        $this->set(compact('leaveRequest','employeeOfficeLocation','reliever', 'employees','employeeName','employeeReportingManager','employeeId','sick_taken','casual_taken','LWoP_taken','earned_taken','unplanned_taken','planned_taken','remainingUnplannedLeave','remainingPlannedLeave','totalLeaveTaken','totalLeaveTakenForGoa','remainingSickLeave','remainingCasualLeave','restricted_taken','remainingRestrictedLeave','remainingEarnedLeave','dayOffTaken','remainingDayOffLeave','employeeType','leaveTypes','half_day'));
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
