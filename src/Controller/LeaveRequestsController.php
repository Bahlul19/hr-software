<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;

/**
 * LeaveRequests Controller
 *
 * @property \App\Model\Table\LeaveDaysTable $LeaveDays
 *
 * @property \App\Model\Table\LeaveRequestsTable $LeaveRequests
 *
 * @method \App\Model\Entity\LeaveRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeaveRequestsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' =>    ['Employees']
        ];

        $employeeId = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');
        $reportingManagerId = $this->Auth->user('reporting_manager');
        $listForReportingManager = $this->LeaveRequests->find()->WHERE(['reporting_managerId' => $employeeId])->WHERE(['status' => 1]);

        if($roleId == 2){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } elseif (!empty($listForReportingManager)){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['OR'=>['employee_id'=>$employeeId,'reporting_managerId'=>$employeeId]])->WHERE(['status'=>1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } else {

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['employee_id' => $employeeId ])->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }

        $this->set(compact('leaveRequests','roleId'));
    }

    /**
     * View method
     *
     * @param string|null $id Leave Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leaveRequest = $this->LeaveRequests->get($id, [
            'contain' => ['Employees']
        ]);
        $userName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $isReportingManager = $this->Auth->user('id');
        $roleId = $this->Auth->user('role_id');

        $this->set(compact('leaveRequest','designationId','userName','isReportingManager','roleId'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // User info
        $employeeId = $this->Auth->user('id');
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $employeeReportingManager = $this->Auth->user('reporting_manager');
        $employeeType = $this->Auth->user('employment_type');
        $employeeOfficeLocation = $this->Auth->user('office_location');
        //validation
        $getLeaveDays = $this->LeaveRequests->totalLeaveData($employeeId);
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
        $half_sick_taken = $this->LeaveRequests->halfDayLeave($employeeId,1);
        $sick_taken = $this->LeaveRequests->fullDayLeave($employeeId,1,'sick_leave_taken')+$half_sick_taken;
        $remainingSickLeave = $getLeaveDays['sick_leave'];

        // LWoP Leave Info For Full Day
        $half_LWoP_taken = $this->LeaveRequests->halfDayLeave($employeeId,3);
        $LWoP_taken = $this->LeaveRequests->fullDayLeave($employeeId,3,'lwop_leave_taken')+$half_LWoP_taken;

        // Earned Leave Info for Full Day
        $half_earned_taken = $this->LeaveRequests->halfDayLeave($employeeId,4);
        $earned_taken = $this->LeaveRequests->fullDayLeave($employeeId,4,'earned_leave_taken')+$half_earned_taken;
        $remainingEarnedLeave = $getLeaveDays['earned_leave'];

        $half_unplanned_taken = $this->LeaveRequests->halfDayLeave($employeeId,5);
        $unplanned_taken = $this->LeaveRequests->fullDayLeave($employeeId,5,'unplanned_leave_taken')+$half_unplanned_taken;
        $remainingUnplannedLeave = $getLeaveDays['unplanned_leave'];

        $half_planned_taken = $this->LeaveRequests->halfDayLeave($employeeId,6);
        $planned_taken = $this->LeaveRequests->fullDayLeave($employeeId,6,'planned_leave_taken')+$half_planned_taken;
        $remainingPlannedLeave = $getLeaveDays['planned_leave'];

        $half_restricted_holiday_taken = $this->LeaveRequests->halfDayLeave($employeeId,7);
        $restricted_taken = $this->LeaveRequests->fullDayLeave($employeeId,7,'restricted_leave_taken') + $half_restricted_holiday_taken;
        $remainingRestrictedLeave = $getLeaveDays['restricted_leave'];

        $half_day_off_taken = $this->LeaveRequests->halfDayLeave($employeeId,8);
        $dayOffTaken = $this->LeaveRequests->fullDayLeave($employeeId,8,'day_off_taken') + $half_day_off_taken;
        $remainingDayOffLeave = $getLeaveDays['day_off'];

        //check if user is an intern or other
        if($employeeType == 'intern'){
            $casual_taken = "0";
        } 
        else {        
            // Full Casual Leave Info
            $half_casual_taken = $this->LeaveRequests->halfDayLeave($employeeId,2);
            $casual_taken = $this->LeaveRequests->fullDayLeave($employeeId,2,'casual_leave_taken')+$half_casual_taken;
            // calculation for total causal leave
            $remainingCasualLeave=$getLeaveDays['casual_leave'];
        }

        $totalLeaveTaken = $this->LeaveRequests->totalLeave($sick_taken,$casual_taken,$LWoP_taken,$earned_taken);
        $totalLeaveTakenForGoa =  $this->LeaveRequests->totalLeaveForGoa($unplanned_taken,$planned_taken,$restricted_taken);

        $leaveRequest = $this->LeaveRequests->newEntity();

        //Code to be executed if form is submitted.
        if ($this->request->is('post')) 
        {
            $LeaveRequestsForm = $this->request->getData();
            $LeaveRequestsForm = $this->LeaveRequests->convertStringtoDateFormat($LeaveRequestsForm);
            $leaveRequest = $this->LeaveRequests->patchEntity($leaveRequest, $LeaveRequestsForm);
            
            $reportingManagerId = $this->Auth->user('reporting_manager');
            $reportingManagerEmail = $this->LeaveRequests->reportingManagerEmail($reportingManagerId);
            $leaveRequest->no_of_days = $LeaveRequestsForm['no_of_days'];
            if ($this->LeaveRequests->save($leaveRequest)) {

                $applierEmail = $this->Auth->user('office_email');
                $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto($reportingManagerEmail)
                        ->setCc('hr@managedcoder.com')
                        ->setemailFormat('html')
                        ->setTemplate('lr_apply')
                        ->setsubject($applierName . ' Applied for Leave')
                        ->setViewVars(['applierName' => $applierName,
                        'date_from' => $LeaveRequestsForm['date_from'],
                        'date_to' => $LeaveRequestsForm['date_to'],
                        'leave_reason' => $LeaveRequestsForm['leave_reason'],
                        'reliever' => $LeaveRequestsForm['reliever'],
                        'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                        'leaveId' => $leaveRequest->id,
                        'no_of_days' => $LeaveRequestsForm['no_of_days'],
                        'leave_type' => $this->LeaveRequests->getLeaveTypeByLeaveId($LeaveRequestsForm['leave_type'])])
                        ->send();

                $this->Flash->success(__('The leave request has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave request could not be saved. Please, try again.'));
        }
        $employees = $this->LeaveRequests->Employees->find('list', ['limit' => 200]);
        $this->set(compact('leaveRequest','employeeOfficeLocation', 'employees','employeeName','employeeReportingManager','employeeId','sick_taken','casual_taken','LWoP_taken','earned_taken','unplanned_taken','planned_taken','remainingUnplannedLeave','remainingPlannedLeave','totalLeaveTaken','totalLeaveTakenForGoa','employeeDesignationId','remainingSickLeave','remainingCasualLeave','restricted_taken','remainingRestrictedLeave','remainingEarnedLeave','dayOffTaken','remainingDayOffLeave','employeeType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Leave Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leaveRequest = $this->LeaveRequests->get($id, [
            'contain' => []
        ]);
        // User info
        $employeeId = $this->Auth->user('id');
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $employeeReportingManager = $this->Auth->user('reporting_manager');
        $employeeType = $this->Auth->user('employment_type');
        $employeeOfficeLocation = $this->Auth->user('office_location');

        $getLeaveDays = $this->LeaveRequests->totalLeaveData($leaveRequest->employee_id);
        if(empty($getLeaveDays)){
            $getLeaveDays['sick_leave'] = 0;
            $getLeaveDays['casual_leave']= 0;
            $getLeaveDays['earned_leave']= 0;
            $getLeaveDays['unplanned_leave']= 0;
            $getLeaveDays['planned_leave']= 0;
            $getLeaveDays['restricted_leave']= 0;
            $getLeaveDays['day_off']= 0;
        }

        /*Sick Leave Info */
        $half_sick_taken = $this->LeaveRequests->halfDayLeave($employeeId,1);//for half day
        $sick_taken = $this->LeaveRequests->fullDayLeave($employeeId,1,'sick_leave_taken')+$half_sick_taken;//for full day
        $remainingSickLeave = $getLeaveDays['sick_leave']; //remaining sick leave
        /*LWOP Leave Info */
        $half_LWoP_taken = $this->LeaveRequests->halfDayLeave($employeeId,3);//for half day
        $LWoP_taken = $this->LeaveRequests->fullDayLeave($employeeId,3,'lwop_leave_taken')+$half_LWoP_taken;//for full day

        /* Earned Leave Info */
        $half_earned_taken = $this->LeaveRequests->halfDayLeave($employeeId,4);//for half day
        $earned_taken = $this->LeaveRequests->fullDayLeave($employeeId,4,'earned_leave_taken')+$half_earned_taken;//for full day
        $remainingEarnedLeave = $getLeaveDays['earned_leave'];//remaining Earned Leave

        $half_unplanned_taken = $this->LeaveRequests->halfDayLeave($employeeId,5);
        $unplanned_taken = $this->LeaveRequests->fullDayLeave($employeeId,5,'unplanned_leave_taken')+$half_unplanned_taken;
        $remainingUnplannedLeave = $getLeaveDays['unplanned_leave'];

        $half_planned_taken = $this->LeaveRequests->halfDayLeave($employeeId,6);
        $planned_taken = $this->LeaveRequests->fullDayLeave($employeeId,6,'planned_leave_taken')+$half_planned_taken;
        $remainingPlannedLeave = $getLeaveDays['planned_leave'];

        $half_restricted_holiday_taken = $this->LeaveRequests->halfDayLeave($employeeId,7);
        $restricted_taken = $this->LeaveRequests->fullDayLeave($employeeId,7,'restricted_leave_taken') + $half_restricted_holiday_taken;
        $remainingRestrictedLeave = $getLeaveDays['restricted_leave'];

        //check if user is an intern or other
        if($employeeType == 'intern'){
            $casual_taken = "0";
        } 
        else {        
            /*Full Casual Leave Info */
            $half_casual_taken = $this->LeaveRequests->halfDayLeave($employeeId,2);//for half day
            $casual_taken = $this->LeaveRequests->fullDayLeave($employeeId,2,'casual_leave_taken')+$half_casual_taken;//for full day
            $remainingCasualLeave=$getLeaveDays['casual_leave'];//remaining casual leave
        }   

        $totalLeaveTaken = $this->LeaveRequests->totalLeave($sick_taken,$casual_taken,$LWoP_taken,$earned_taken);
        $totalLeaveTakenForGoa =  $this->LeaveRequests->totalLeaveForGoa($unplanned_taken,$planned_taken,$restricted_taken);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $LeaveRequestsForm = $this->request->getData();
            $LeaveRequestsForm = $this->LeaveRequests->convertStringtoDateFormat($LeaveRequestsForm);
            $leaveRequest = $this->LeaveRequests->patchEntity($leaveRequest, $LeaveRequestsForm);

            if ($this->LeaveRequests->save($leaveRequest)) {
                $this->Flash->success(__('The leave request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave request could not be saved. Please, try again.'));
        }
        $employees = $this->LeaveRequests->Employees->find('list', ['limit' => 200]);
        $this->set(compact('leaveRequest', 'employees','employeeOfficeLocation','employeeId','employeeName','employeeReportingManager','employeeType','sick_taken','casual_taken','LWoP_taken','earned_taken','unplanned_taken','planned_taken','remainingUnplannedLeave','remainingPlannedLeave','remainingSickLeave','remainingCasualLeave','remainingEarnedLeave','restricted_taken','remainingRestrictedLeave','totalLeaveTaken','totalLeaveTakenForGoa'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Leave Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leaveRequest = $this->LeaveRequests->get($id);
        if ($this->LeaveRequests->delete($leaveRequest)) {
            $this->Flash->success(__('The leave request has been deleted.'));
        } else {
            $this->Flash->error(__('The leave request could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    // check for approval
    public function approve($isApprove = null, $id = null, $employee_id = null, $leaveType = null, $halfDay = null)
    {
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $getLeaveDays = $this->LeaveRequests->totalLeaveData($employee_id);

        $leaveRequest = $this->LeaveRequests->get($id, [
            'contain' => ['Employees']
        ]);

        $noOfDays = $this->LeaveRequests->get($id);
        
        if(($isApprove == 1 || $isApprove == 2) && ($leaveType == 1 || $leaveType == 2 ||$leaveType == 3 ||$leaveType == 4 ||$leaveType == 5 ||$leaveType == 6 ||$leaveType == 7 ||$leaveType == 8) && $halfDay == 0 ){
            //Logic for full day leave approval.            
            $CheckApprovalDecision = $this->LeaveRequests->isFullApproved($leaveRequest, $isApprove, $leaveType, $employeeName, $getLeaveDays);
            $CheckApprovalDecisionCalculation = $this->LeaveRequests->remainingCalculateFull($CheckApprovalDecision,$getLeaveDays);
        }
        
        if(($isApprove == 1 || $isApprove == 2) && ($leaveType == 1 || $leaveType == 2 ||$leaveType == 3 ||$leaveType == 4 ||$leaveType == 5 ||$leaveType == 6 ||$leaveType == 7 ||$leaveType == 8) && $halfDay > 0){
            //Logic for half day leave approval.
            $CheckApprovalDecision = $this->LeaveRequests->isHalfApproved($leaveRequest, $leaveType, $isApprove, $halfDay, $employeeName);
            $CheckApprovalDecisionCalculation = $this->LeaveRequests->remainingCalculateHalf($CheckApprovalDecision,$getLeaveDays);
        }

         $UpdateRemainingLeave = $this->LeaveRequests->updateRemainingLeaves($CheckApprovalDecisionCalculation);
        if ($this->LeaveRequests->save($CheckApprovalDecision)) {
            if($UpdateRemainingLeave == true) {
                if ($isApprove == 1) {

                    $approverEmail = $this->Auth->user('office_email');
                    $applierEmail = $CheckApprovalDecision->employee['office_email'];

                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto($applierEmail)
                        ->setcc('hr@managedcoder.com')
                        ->setemailFormat('html')
                        ->setTemplate('lr_approve')
                        ->setsubject('Your Leave has been Approved')
                        ->setViewVars(['applierName' => $CheckApprovalDecision->employee['first_name'] . ' ' . $CheckApprovalDecision->employee['last_name'], 'date_from' => $noOfDays['date_from'], 'date_to' => $noOfDays['date_to'], 'leave_reason' => $noOfDays['leave_reason'], 'reliever' => $noOfDays['reliever'], 'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png', 'leaveId' => $leaveRequest->id, 'leaveType' => $this->LeaveRequests->getLeaveTypeByLeaveId($leaveType), 'noOfDays' => $noOfDays['no_of_days']])
                        ->send();

                    $this->Flash->success(__('The leave request has been Approved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The leave request has been Declined.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
        $this->Flash->error(__('The leave request could not be processed. Please, try again.'));


    }

    // add reject reason
    public function rejectReason($isApprove = null, $id = null,$employee_id = null,$leaveType = null, $halfDay = null)
    {
           
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');        
        $leaveRequest = $this->LeaveRequests->get($id, [
            'contain' => ['Employees']
        ]);
        
        $noOfDays = $this->LeaveRequests->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $rejectReason = $this->request->getData();

            if(($isApprove == 1 || $isApprove == 2) && ($leaveType == 1 || $leaveType == 2 ||$leaveType == 3 ||$leaveType == 4 ||$leaveType == 5 ||$leaveType == 6) && $halfDay == 0 ){
                $CheckApprovalDecision = $this->LeaveRequests->isFullApproved($leaveRequest,$isApprove,$leaveType,$employeeName);
            }
             if(($isApprove == 1 || $isApprove == 2) && ($leaveType == 1 || $leaveType == 2 ||$leaveType == 3 ||$leaveType == 4 ||$leaveType == 5 ||$leaveType == 6) &&$halfDay > 0){
                $CheckApprovalDecision = $this->LeaveRequests->isHalfApproved($leaveRequest,$leaveType,$isApprove,$halfDay,$employeeName);
             }  
            
            $CheckApprovalDecision['reject_reason'] = $rejectReason['reject_reason'];
            $CheckApprovalDecision['is_approved'] = $rejectReason['is_approved'];
            $CheckApprovalDecision['approved_by'] = $rejectReason['approved_by'];
            $leaveRequest = $this->LeaveRequests->patchEntity($leaveRequest,$rejectReason);

            if ($this->LeaveRequests->save($leaveRequest)) {

                $employees = TableRegistry::get('Employees');
                $applicant = $employees->get($rejectReason['applicant']);

                $approverEmail = $this->Auth->user('office_email');

                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto($applicant->office_email)
                        ->setcc('hr@managedcoder.com')
                        ->setemailFormat('html')
                        ->setTemplate('lr_denied')
                        ->setsubject('Your Leave has been Denied')
                        ->setViewVars(['applierName' => $applicant->first_name . ' ' . $applicant->last_name, 'date_from' => $rejectReason['date_from'], 'date_to' => $rejectReason['date_to'], 'leave_reason' => $rejectReason['leave_reason'], 'reliever' => $rejectReason['reliever'], 'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png', 'leaveId' => $leaveRequest->id, 'leaveType' => $this->LeaveRequests->getLeaveTypeByLeaveId($leaveType), 'noOfDays' => $noOfDays['no_of_days'], 'leaveReason' => $CheckApprovalDecision['reject_reason']])
                        ->send('Your leave request has been Rejected. Reason: ' . $CheckApprovalDecision['reject_reason']);

                $this->Flash->success(__('The leave request has been rejected.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave request could not be rejected. Please, try again.'));
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
        $listForReportingManager = $this->LeaveRequests->find()->WHERE(['reporting_managerId' => $employeeId])->WHERE(['is_approved'=> 0])->WHERE(['status' => 1]);

        if($roleId == 2){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['is_approved' => 0])->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } elseif (!empty($listForReportingManager)){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['OR'=>['employee_id'=>$employeeId,'reporting_managerId'=>$employeeId]])->WHERE(['is_approved'=>0])->WHERE(['status'=>1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } else {

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['employee_id' => $employeeId ])->WHERE(['is_approved'=> 0])->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }

        $this->set(compact('leaveRequests','roleId'));
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
        $listForReportingManager = $this->LeaveRequests->find()->WHERE(['reporting_managerId' => $reportingManagerId ])->WHERE(['is_approved'=> 1])->WHERE(['status' => 1]);
        if($roleId == 2){

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['is_approved'=> 1])->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } elseif (!empty($listForReportingManager)){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['OR'=>['employee_id'=>$employeeId,'reporting_managerId'=>$employeeId]])->WHERE(['is_approved'=>1])->WHERE(['status'=>1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }  else {

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['employee_id' => $employeeId ])->WHERE(['is_approved'=> 1])->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }

        $this->set(compact('leaveRequests','roleId'));
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
        $listForReportingManager = $this->LeaveRequests->find()->WHERE(['reporting_managerId' => $reportingManagerId ])->WHERE(['is_approved'=> 2])->WHERE(['status' => 1]);

        if($roleId == 2){

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['is_approved'=> 2])->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        } elseif (!empty($listForReportingManager)){
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            } else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['OR'=>['employee_id'=>$employeeId,'reporting_managerId'=>$employeeId]])->WHERE(['is_approved'=>2])->WHERE(['status'=>1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }
        }  else {

            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $leaveRequests = $this->LeaveRequests->searchByName($keyword);
                $leaveRequests = $this->paginate($leaveRequests);
            }
            else {
                $LeaveRequests = $this->LeaveRequests->find()->WHERE(['employee_id' => $employeeId ])->WHERE(['is_approved'=> 2])->WHERE(['status' => 1]);
                $leaveRequests = $this->paginate($LeaveRequests);
            }            
        }

        $this->set(compact('leaveRequests','roleId'));
    }


    
    public function sendMail(){
        $this->autoRender=false;
        $email = new Email();
        $email->transport('sendgrid');
        $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
            ->setto("sankelp.chari@sjinnovation.com")
            ->setemailFormat('html')
            ->setTemplate('default')
            ->setsubject('Your Leave has been Denied')
            ->send('Your leave request has been Rejected. Reason: ');

            debug($email);

    }
}


