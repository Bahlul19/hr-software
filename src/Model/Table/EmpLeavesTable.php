<?php
namespace App\Model\Table;

use Cake\Mailer\Email;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * EmpLeaves Model
 *
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\EmpLeave get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmpLeave newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmpLeave[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmpLeave|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpLeave|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpLeave patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmpLeave[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmpLeave findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmpLeavesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('emp_leaves');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
    }

    //remaining calculation for taking fullday Leave
    public function remainingCalculateFull($CheckApprovalDecision,$getLeaveDays)
    {
        $leaveType = $CheckApprovalDecision['leave_type'];

        switch ($leaveType) {
            case 1:
                $getLeaveDays['sick_leave'] -= $CheckApprovalDecision['sick_leave_taken'];
                break;

            case 2:
                $getLeaveDays['casual_leave'] -= $CheckApprovalDecision['casual_leave_taken'];
                break;

            case 3:

                break;

            case 4:
                $getLeaveDays['earned_leave'] -= $CheckApprovalDecision['earned_leave_taken'];
                break;

            case 5:
                $getLeaveDays['unplanned_leave'] -= $CheckApprovalDecision['unplanned_leave_taken'];
                break;

            case 6:
                $getLeaveDays['planned_leave'] -= $CheckApprovalDecision['planned_leave_taken'];
                break;

            case 7:
                $getLeaveDays['restricted_leave'] -= $CheckApprovalDecision['restricted_leave_taken'];
                break;

            case 8:
                $getLeaveDays['day_off'] -= $CheckApprovalDecision['day_off_taken'];
                break;

            default:
        }

        return $getLeaveDays;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('employee_name')
            ->maxLength('employee_name', 100)
            ->requirePresence('employee_name', 'create')
            ->notEmpty('employee_name');

        // $validator
        //     ->integer('reporting_managerId')
        //     ->allowEmpty('reporting_managerId');

        $validator
            ->integer('leave_type')
            ->requirePresence('leave_type', 'create')
            ->notEmpty('leave_type');

        $validator
            ->requirePresence('date_from', 'create')
            ->notEmpty('date_from','Please Select A "From" Date');

        $validator
            ->requirePresence('date_to', 'create')
            ->notEmpty('date_to','Please Select A "To" Date');

        $validator
            ->numeric('no_of_days')
            ->requirePresence('no_of_days', 'create')
            ->notEmpty('no_of_days');

        // $validator
        //     ->integer('half_day')
        //     ->requirePresence('half_day', 'create')
        //     ->notEmpty('half_day');

        $validator
            ->scalar('leave_reason')
            ->requirePresence('leave_reason', 'create')
            ->notEmpty('leave_reason');

        // $validator
        //     ->integer('sick_leave_taken')
        //     ->requirePresence('sick_leave_taken', 'create')
        //     ->notEmpty('sick_leave_taken');

        // $validator
        //     ->integer('casual_leave_taken')
        //     ->requirePresence('casual_leave_taken', 'create')
        //     ->notEmpty('casual_leave_taken');

        // $validator
        //     ->integer('lwop_leave_taken')
        //     ->requirePresence('lwop_leave_taken', 'create')
        //     ->notEmpty('lwop_leave_taken');

        // $validator
        //     ->integer('earned_leave_taken')
        //     ->requirePresence('earned_leave_taken', 'create')
        //     ->notEmpty('earned_leave_taken');

        // $validator
        //     ->integer('unplanned_leave_taken')
        //     ->requirePresence('unplanned_leave_taken', 'create')
        //     ->notEmpty('unplanned_leave_taken');

        // $validator
        //     ->integer('planned_leave_taken')
        //     ->requirePresence('planned_leave_taken', 'create')
        //     ->notEmpty('planned_leave_taken');

        // $validator
        //     ->integer('restricted_leave_taken')
        //     ->requirePresence('restricted_leave_taken', 'create')
        //     ->notEmpty('restricted_leave_taken');

        // $validator
        //     ->integer('day_off_taken')
        //     ->requirePresence('day_off_taken', 'create')
        //     ->notEmpty('day_off_taken');

        // $validator
        //     ->integer('half_day_taken')
        //     ->requirePresence('half_day_taken', 'create')
        //     ->notEmpty('half_day_taken');

        // $validator
        //     ->requirePresence('is_approved', 'create')
        //     ->notEmpty('is_approved');

        // $validator
        //     ->scalar('approved_by')
        //     ->maxLength('approved_by', 100)
        //     ->requirePresence('approved_by', 'create')
        //     ->notEmpty('approved_by');

        $validator
            ->scalar('reliever')
            ->maxLength('reliever', 100)
            ->requirePresence('reliever', 'create')
            ->notEmpty('reliever');

        // $validator
        //     ->scalar('reject_reason')
        //     ->requirePresence('reject_reason', 'create')
        //     ->notEmpty('reject_reason');

        // $validator
        //     ->integer('status')
        //     ->requirePresence('status', 'create')
        //     ->notEmpty('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));

        return $rules;
    }

    // function for calculating leave days
    public function totalLeaveData($employeeId)
    {
        $LeaveDays = TableRegistry::get('LeaveDays');
        $leaveData = $LeaveDays->find()->WHERE(['employee_id' => $employeeId]);

        $leaveDay = array();
        foreach ($leaveData as $leaveDays){
            $leaveDay['id']         = $leaveDays['id'];
            $leaveDay['employee_id']= $leaveDays['employee_id'];
            $leaveDay['sick_leave'] = $leaveDays['sick_leave'];
            $leaveDay['casual_leave'] = $leaveDays['casual_leave'];
            $leaveDay['earned_leave'] = $leaveDays['earned_leave'];
            $leaveDay['unplanned_leave'] = $leaveDays['unplanned_leave'];
            $leaveDay['planned_leave'] = $leaveDays['planned_leave'];
            $leaveDay['restricted_leave'] = $leaveDays['restricted_leave'];
            $leaveDay['day_off'] = $leaveDays['day_off'];
        }
        return $leaveDay;
    }
    // function for half day leave
    public function halfDayLeave($employeeId,$leave_type)
    {
        $current_date = Configure::read('current_year').'-01-01';
        $LeaveRequests = TableRegistry::get('EmpLeaves');
        $half_sick_result_1st_half= 0;
        $half_sick_result_2nd_half= 0;

        $half_sick_result_1st_half = $LeaveRequests->find()->select('half_day_taken')->WHERE(['employee_id'=>$employeeId])->WHERE(['leave_type'=>$leave_type])->WHERE(['half_day_taken'=>1])->WHERE(['status'=>1,'date_from >='=>$current_date,'date_to >='=>$current_date])->count();
        $half_sick_result_2nd_half = $LeaveRequests->find()->select('half_day_taken')->WHERE(['employee_id'=>$employeeId])->WHERE(['leave_type'=>$leave_type])->WHERE(['half_day_taken'=>2])->WHERE(['status'=>1,'date_from >='=>$current_date,'date_to >='=>$current_date])->count();

        $half_sick_result = $half_sick_result_1st_half + $half_sick_result_2nd_half;


        $half_sick_taken = 0;
        if(!empty($half_sick_result)){
            $half_sick_taken+=(0.5*$half_sick_result);
        }

        return $half_sick_taken;
    }

    //  function for full day leave
    public function fullDayLeave($employeeId,$leave_type,$leaveTypeName)
    {
        $current_date = Configure::read('current_year').'-01-01';
        $LeaveRequests = TableRegistry::get('EmpLeaves');
        $sick_result = $LeaveRequests->find()->select($leaveTypeName)->WHERE(['employee_id'=>$employeeId])->WHERE(['leave_type'=>$leave_type])->WHERE(['status'=>1,'emp_leave_cancellation' => 0,'date_from >='=>$current_date,'date_to >='=>$current_date]);
        $sick_taken = 0;
        foreach($sick_result as $r){
            $sick_taken+=$r[$leaveTypeName];
        }
        return $sick_taken;
      
    }

    // Function for calculating total leave
    public function totalLeave($sick_taken, $casual_taken, $LWoP_taken, $earned_taken)
    {
        if(!empty($casual_taken)){
            return $total_Leave = $sick_taken + $casual_taken + $LWoP_taken + $earned_taken;
        }
        else {
            return $total_Leave = $sick_taken + $LWoP_taken+$earned_taken;
        }
    }

    public function totalLeaveForGoa($LWoP_taken, $unplanned_taken,$planned_taken,$restricted_taken)
    {

        return $total_Leave = $LWoP_taken + $unplanned_taken + $planned_taken + $restricted_taken;
    }

    public function convertStringtoDateFormat($LeaveRequestsForm)
    {
        $LeaveRequestsForm['date_from'] = date('Y-m-d', strtotime($LeaveRequestsForm['date_from']));
        $LeaveRequestsForm['date_to'] = date('Y-m-d', strtotime($LeaveRequestsForm['date_to']));
        
        return $LeaveRequestsForm;
    }

    //for getting reporting manager email.
    public function reportingManagerEmail($id = null)
    {
        $employees = TableRegistry::get('Employees');
        $reportingManagerEmail = $employees->find('all')->select('office_email')->WHERE(['id'=>$id])->toArray();

        $email = array();
        foreach ($reportingManagerEmail as $rme){
            $email = $rme['office_email'];
        }

        return $email;
    }

    public function employeeEmail($id = null)
    {
        $employees = TableRegistry::get('Employees');
        $reportingManagerEmail = $employees->find('all')->select('office_email')->WHERE(['id'=>$id])->toArray();

        $email = array();
        foreach ($reportingManagerEmail as $rme){
            $email = $rme['office_email'];
        }

        return $email;
    }

    public function getLeaveTypeByLeaveId($leaveId)
    {
        switch($leaveId){
            case 1:{ return 'Sick Leave'; break; }
            case 2:{ return 'Casual Leave'; break; }
            case 3:{ return 'LWoP Leave'; break; }
            case 4:{ return 'Earned Leave'; break; }
            case 5:{ return 'Un-Planned Leave'; break; }
            case 6:{ return 'Planned Leave'; break; }
            case 7:{ return 'Restricted Holiday'; break; }
            case 8:{ return 'Day Off / vacation'; break; }
            default: { return $leaveId; break; }
        }
    }

    public function searchByName($keyword)
    {
        $results = $this->find(
            'all', array('conditions' => [['CONCAT(LeaveRequests.employee_name) like' => '%' . $keyword . '%']
        ]
        ));

        return $results;
    }

    // function for Half day approval
    public function isHalfApproved($getValue,$leaveType,$isApprove,$halfday,$employeeName)
    {

        if($isApprove == 1){

            if($halfday == 1){
                if($leaveType == 1){
                    $getValue['sick_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 2){
                    $getValue['casual_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']        = $employeeName;
                }
                if($leaveType == 3){
                    $getValue['lwop_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 4){
                    $getValue['earned_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 5){
                    $getValue['unplanned_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 6){
                    $getValue['planned_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 7){
                    $getValue['restricted_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 8){
                    $getValue['day_off_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }

                $getValue['half_day_taken'] = $getValue['half_day'];

                $getValue['approved_by']    = $employeeName;
            }
            if($halfday == 2){
                if($leaveType == 1){
                    $getValue['sick_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 2){
                    $getValue['casual_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']        = $employeeName;
                }
                if($leaveType == 3){
                    $getValue['lwop_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 4){
                    $getValue['earned_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 5){
                    $getValue['unplanned_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 6){
                    $getValue['planned_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 7){
                    $getValue['restricted_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }
                if($leaveType == 8){
                    $getValue['day_off_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                }

                $getValue['half_day_taken'] = $getValue['half_day'];
                $getValue['approved_by']    = $employeeName;
            }
            $getValue['is_approved']      = $isApprove;
        } else {
            $getValue['is_approved']      = $isApprove;
        }

        return $getValue;
    }

    //remaining calculation for taking halfday Leave
    public function remainingCalculateHalf($CheckApprovalDecision,$getLeaveDays)
    {
        $leaveType = $CheckApprovalDecision['leave_type'] == 1;

        switch ($leaveType) {
            case 1:
                $getLeaveDays['sick_leave'] -= 0.5;
                break;

            case 2:
                $getLeaveDays['casual_leave'] -= 0.5;
                break;

            case 3:

                break;

            case 4:
                $getLeaveDays['earned_leave'] -= 0.5;
                break;

            case 5:
                $getLeaveDays['unplanned_leave'] -= 0.5;
                break;

            case 6:
                $getLeaveDays['unplanned_leave'] -= 0.5;
                break;

            case 7:
                $getLeaveDays['restricted_leave'] -= 0.5;
                break;

            case 8:
                $getLeaveDays['day_off'] -= 0.5;
                break;

            default:

        }

        return $getLeaveDays;
    }

    // function for Full day approval
    public function isFullApproved($getValue,$isApprove,$leaveType,$employeeName, $getLeaveDays)
    {
        $getValue['sick_leave_taken'] = 0;
        $getValue['casual_leave_taken'] = 0;
        $getValue['lwop_leave_taken'] = 0;
        $getValue['earned_leave_taken'] = 0;
        $getValue['unplanned_leave_taken'] = 0;
        $getValue['planned_leave_taken'] = 0;
        $getValue['restricted_leave_taken'] = 0;
        $getValue['day_off_taken'] = 0;
        $getValue['half_day_taken'] = 0;

        if($isApprove == 1){
            switch ($leaveType) {
                case 1:
                    $getValue['sick_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                    break;

                case 2:
                    $getValue['casual_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']        = $employeeName;
                    break;

                case 3:
                    $getValue['lwop_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                    break;

                case 4:
                    $getValue['earned_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                    break;

                case 5:
                    $getValue['unplanned_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                    break;

                case 6:
                    $getValue['planned_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                    break;

                case 7:
                    $getValue['restricted_leave_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                    break;

                case 8:
                    $getValue['day_off_taken'] = $getValue['no_of_days'];
                    $getValue['approved_by']      = $employeeName;
                    break;
            }

            $getValue['is_approved']      = $isApprove;
            //$getValue['half_day_taken'] = $getValue['half_day'];

        } else {
            $getValue['is_approved']      = $isApprove;
        }
        return $getValue;
    }

    public function updateRemainingLeaves($remainingLeaves)
    {
        $LeaveDays = TableRegistry::get('LeaveDays');
        $id = $remainingLeaves['id'];
        $remainingDays = $LeaveDays->get($id);
        $remainingDays->sick_leave = $remainingLeaves['sick_leave'];
        $remainingDays->casual_leave = $remainingLeaves['casual_leave'];
        $remainingDays->earned_leave = $remainingLeaves['earned_leave'];
        $remainingDays->unplanned_leave = $remainingLeaves['unplanned_leave'];
        $remainingDays->planned_leave = $remainingLeaves['planned_leave'];
        $remainingDays->restricted_leave = $remainingLeaves['restricted_leave'];
        $remainingDays->day_off = $remainingLeaves['day_off'];

        $update = $LeaveDays->save($remainingDays);
        return $update;
    }

    public function sendNotificationWhenAnyLeaveRemainingIsZero($sick_leave, $casual_leave, $earned_leave,
                                                                $planned_leave, $unplanned_leave, $restricted_leave, $lwop_leave_taken, $leaveRequest, $officeLocation) {

        $reportingManagerEmail = $this->reportingManagerEmail($leaveRequest->reporting_managerId);
        $employeeWhoAppliedLeaveRequestOfficeEmail = $this->employeeEmail($leaveRequest->employee_id);

        $emailTo = array();
        $emailTo[] = $reportingManagerEmail;
        $emailTo[] = $employeeWhoAppliedLeaveRequestOfficeEmail;

        if($officeLocation == "SYL" && ($sick_leave <= 0 || $casual_leave <= 0 || $earned_leave <= 0 || $lwop_leave_taken >= 20)) {
            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                ->setto($emailTo)
                ->setcc('hr@managedcoder.com')
                ->setemailFormat('html')
                ->setTemplate('lr_remaining_leave_equal_to_zero')
                ->setsubject($leaveRequest->employee_name . ', you have zero remaining leave days for below leave type #' . rand(108512, 709651))
                ->setViewVars(['applierName' => $leaveRequest->employee_name,
                    'date_from' => $leaveRequest->date_from,
                    'date_to' => $leaveRequest->date_to,
                    'leave_reason' => $leaveRequest->leave_reason,
                    'reliever' => $leaveRequest->reliever,
                    'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                    'leaveId' => $leaveRequest->id,
                    'leaveType' => $this->getLeaveTypeByLeaveId($leaveRequest->leave_type),
                    'noOfDays' => $leaveRequest->no_of_days,
                    'sick_leave' => $sick_leave,
                    'casual_leave' => $casual_leave,
                    'earned_leave' => $earned_leave,
                    'planned_leave' => $planned_leave,
                    'unplanned_leave' => $unplanned_leave,
                    'restricted_leave' => $restricted_leave,
                    'lwop_leave_taken' => $lwop_leave_taken,
                    'office_location' => $officeLocation])
                ->send();
        }
        else if($officeLocation == "GOA" && ($planned_leave <= 0 || $unplanned_leave <= 0 || $restricted_leave <= 0 || $lwop_leave_taken >= 20)) {
            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                ->setto($emailTo)
                ->setcc('hr@managedcoder.com')
                ->setemailFormat('html')
                ->setTemplate('lr_remaining_leave_equal_to_zero')
                ->setsubject($leaveRequest->employee_name . ', you have zero remaining leave days for below leave type #' . rand(108512, 709651))
                ->setViewVars(['applierName' => $leaveRequest->employee_name,
                    'date_from' => $leaveRequest->date_from,
                    'date_to' => $leaveRequest->date_to,
                    'leave_reason' => $leaveRequest->leave_reason,
                    'reliever' => $leaveRequest->reliever,
                    'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                    'leaveId' => $leaveRequest->id,
                    'leaveType' => $this->getLeaveTypeByLeaveId($leaveRequest->leave_type),
                    'noOfDays' => $leaveRequest->no_of_days,
                    'sick_leave' => $sick_leave,
                    'casual_leave' => $casual_leave,
                    'earned_leave' => $earned_leave,
                    'planned_leave' => $planned_leave,
                    'unplanned_leave' => $unplanned_leave,
                    'restricted_leave' => $restricted_leave,
                    'lwop_leave_taken' => $lwop_leave_taken,
                    'office_location' => $officeLocation])
                ->send();
        }
    }

    public function sendNotificationForUnplannedLeaveTakenMoreThanThreeDays($leaveRequest, $getLeaveDays) {
        $LeaveDays = TableRegistry::get('LeaveDays');
        $id = $getLeaveDays['id'];
        $remainingDays = $LeaveDays->get($id);

        $initialUnplannedLeave = $remainingDays->initial_unplanned_leave;
        $remainingUnplannedLeave = $remainingDays->unplanned_leave;

        $reportingManagerEmail = $this->reportingManagerEmail($leaveRequest->reporting_managerId);
        $employeeWhoAppliedLeaveRequestOfficeEmail = $this->employeeEmail($leaveRequest->employee_id);

        $emailTo = array();

        if(!empty($reportingManagerEmail))
        {
        $emailTo[] = $reportingManagerEmail;
        }
        $emailTo[] = $employeeWhoAppliedLeaveRequestOfficeEmail;

        if(($initialUnplannedLeave - $remainingUnplannedLeave) >= 3) {
            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                ->setto($emailTo)
                ->setcc('hr@managedcoder.com')
                ->setemailFormat('html')
                ->setTemplate('lr_unplanned_leave_taken_more_than_or_equal_to_three')
                ->setsubject($leaveRequest->employee_name . ', has requested to take more than or equal to three unplanned leave #' . rand(108512, 709651))
                ->setViewVars(['applierName' => $leaveRequest->employee_name,
                    'date_from' => $leaveRequest->date_from,
                    'date_to' => $leaveRequest->date_to,
                    'leave_reason' => $leaveRequest->leave_reason,
                    'reliever' => $leaveRequest->reliever,
                    'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png',
                    'leaveId' => $leaveRequest->id,
                    'leaveType' => $this->getLeaveTypeByLeaveId($leaveRequest->leave_type),
                    'noOfDays' => $leaveRequest->no_of_days,
                    'remainingUnplannedLeaves' => $remainingUnplannedLeave])
                ->send();
        }
    }

    public function isCancelled($leaveRequest){
        $leaveRequest['is_approved'] = 3;

        return $leaveRequest;
    }

    public function updateLeaveDays($leaveRequest)
    {
        $leaveType = $leaveRequest['leave_type'];
        $emp_id = $leaveRequest['employee_id'];
        $LeaveDays = TableRegistry::get('LeaveDays');
        $remainingDays = $LeaveDays->find('all')->WHERE(['employee_id'=>$emp_id])->toArray();

        $update = null;

        foreach($remainingDays as $rd){

            $id = $rd->id;
            $remainingLeaveDays = $LeaveDays->get($id);

            switch ($leaveType) {
                case 1:
                    $remainingLeaveDays->sick_leave = $remainingLeaveDays->sick_leave + $leaveRequest->no_of_days;
                    break;

                case 2:
                    $remainingLeaveDays->casual_leave = $remainingLeaveDays->casual_leave + $leaveRequest->no_of_days;
                    break;

                case 3:
                    break;

                case 4:
                    $remainingLeaveDays->earned_leave = $remainingLeaveDays->earned_leave + $leaveRequest->no_of_days;
                    break;

                case 5:
                    $remainingLeaveDays->unplanned_leave = $remainingLeaveDays->unplanned_leave + $leaveRequest->no_of_days;
                    break;

                case 6:
                    $remainingLeaveDays->planned_leave = $remainingLeaveDays->planned_leave + $leaveRequest->no_of_days;
                    break;

                case 7:
                    $remainingLeaveDays->restricted_leave = $remainingLeaveDays->restricted_leave + $leaveRequest->no_of_days;
                    break;

                case 8:
                    break;

                default:
                    $remainingLeaveDays->day_off = $remainingLeaveDays->day_off + $leaveRequest->no_of_days;
                    break;
            }
            
            $update = $LeaveDays->save($remainingLeaveDays);
        }

        return $update;
    }

    // written by anik to update leave taken on leave request updating
    public function updateLeaveTaken($leaveRequest, $employeeNewLeaveType) {

        switch ($employeeNewLeaveType) {
            case 1:
                //sick leave;
                $leaveRequest->sick_leave_taken = $leaveRequest->no_of_days;
                break;

            case 2:
                //casual leave
                $leaveRequest->casual_leave_taken = $leaveRequest->no_of_days;
                break;

            case 4:
                //earned_leave
                $leaveRequest->earned_leave_taken = $leaveRequest->no_of_days;
                break;

            case 5:
                //unplanned_leave
                $leaveRequest->unplanned_leave_taken = $leaveRequest->no_of_days;
                break;

            case 6:
                //planned_leave
                $leaveRequest->planned_leave_taken = $leaveRequest->no_of_days;
                break;

            case 7:
                //restricted_leave
                $leaveRequest->restricted_leave_taken = $leaveRequest->no_of_days;
                break;

            case 8:
                //day_off
                $leaveRequest->day_off_taken = $leaveRequest->no_of_days;
                break;

            default:
                break;
        }

        return $leaveRequest;
    }

    // reset leave taken
    public function resetUpdateLeaveTaken($leaveRequest) {

        $leaveRequest->sick_leave_taken = 0;
        $leaveRequest->casual_leave_taken = 0;
        $leaveRequest->lwop_leave_taken = 0;
        $leaveRequest->earned_leave_taken = 0;
        $leaveRequest->unplanned_leave_taken = 0;
        $leaveRequest->planned_leave_taken = 0;
        $leaveRequest->restricted_leave_taken = 0;
        $leaveRequest->half_day_taken = 0;
        $leaveRequest->day_off_taken = 0;

        return $leaveRequest;
    }

    // reset leave days
    public function resetLeaveDaysAfterApprovedHRChanges($leaveRequest, $employeePreviousLeaveType)
    {
        $emp_id = $leaveRequest['employee_id'];

        $LeaveDays = TableRegistry::get('LeaveDays');
        $remainingDays = $LeaveDays->find('all')->WHERE(['employee_id'=>$emp_id])->toArray();

        $update = null;

        //dd($leaveRequest);

        foreach($remainingDays as $rd){

            $id = $rd->id;

            $remainingLeaveDays = $LeaveDays->get($id);

            //code for reset all leave Days
            switch ($employeePreviousLeaveType) {
                case 1:
                    $remainingLeaveDays->sick_leave = $remainingLeaveDays->sick_leave + $leaveRequest->no_of_days;
                    break;

                case 2:
                    $remainingLeaveDays->casual_leave = $remainingLeaveDays->casual_leave + $leaveRequest->no_of_days;
                    break;

                case 3:

                    break;

                case 4:
                    $remainingLeaveDays->earned_leave = $remainingLeaveDays->earned_leave + $leaveRequest->no_of_days;
                    break;

                case 5:
                    $remainingLeaveDays->unplanned_leave = $remainingLeaveDays->unplanned_leave + $leaveRequest->no_of_days;
                    break;

                case 6:
                    $remainingLeaveDays->planned_leave = $remainingLeaveDays->planned_leave + $leaveRequest->no_of_days;
                    break;

                case 7:
                    $remainingLeaveDays->restricted_leave = $remainingLeaveDays->restricted_leave + $leaveRequest->no_of_days;
                    break;

                case 8:
                    $remainingLeaveDays->day_off = $remainingLeaveDays->day_off + $leaveRequest->no_of_days;
                    break;

                default:
                    break;
            }

            $update = $LeaveDays->save($remainingLeaveDays);
        }

        return $update;
    }

    //for update this is new function after approved the leave and chnaged the leave type

    public function updateLeaveDaysAfterApprovedHRChanges($leaveRequest, $employeeNewLeaveType)
    {
        $emp_id = $leaveRequest['employee_id'];

        $LeaveDays = TableRegistry::get('LeaveDays');
        $remainingDays = $LeaveDays->find('all')->WHERE(['employee_id'=>$emp_id])->toArray();

        $update = null;

        foreach($remainingDays as $rd){

            $id = $rd->id;

            $remainingLeaveDays = $LeaveDays->get($id);

            switch ($employeeNewLeaveType) {
                case 1:
                    $remainingLeaveDays->sick_leave = $remainingLeaveDays->sick_leave - $leaveRequest->no_of_days;
                    break;

                case 2:
                    $remainingLeaveDays->casual_leave = $remainingLeaveDays->casual_leave - $leaveRequest->no_of_days;
                    break;

                case 3:
                    break;

                case 4:
                    $remainingLeaveDays->earned_leave = $remainingLeaveDays->earned_leave - $leaveRequest->no_of_days;
                    break;

                case 5:
                    $remainingLeaveDays->unplanned_leave = $remainingLeaveDays->unplanned_leave - $leaveRequest->no_of_days;
                    break;

                case 6:
                    $remainingLeaveDays->planned_leave = $remainingLeaveDays->planned_leave - $leaveRequest->no_of_days;
                    break;

                case 7:
                    $remainingLeaveDays->restricted_leave = $remainingLeaveDays->restricted_leave - $leaveRequest->no_of_days;
                    break;

                case 8:
                    $remainingLeaveDays->day_off = $remainingLeaveDays->day_off - $leaveRequest->no_of_days;
                    break;

                default:
                    break;
            }

            $update = $LeaveDays->save($remainingLeaveDays);
        }

        return $update;
    }

    //new code 5:10

    public function updateCancelDate($leaveRequest, $previousLeaveType)
    {
        $leaveType = $previousLeaveType['leave_type'];
        $emp_id = $leaveRequest['employee_id'];
        $LeaveDays = TableRegistry::get('LeaveDays');
        $remainingDays = $LeaveDays->find('all')->WHERE(['employee_id'=>$emp_id])->toArray();

        foreach($remainingDays as $rd){

            $id = $rd->id;
            $remainingLeaveDays = $LeaveDays->get($id);  
            if($leaveType == 1){
                $remainingLeaveDays->sick_leave = $remainingLeaveDays->sick_leave + $leaveRequest->no_of_days;
            }
            elseif($leaveType == 2){
                $remainingLeaveDays->casual_leave = $remainingLeaveDays->casual_leave + $leaveRequest->no_of_days;
            } 
            elseif($leaveType == 4){
                $remainingLeaveDays->earned_leave = $remainingLeaveDays->earned_leave + $leaveRequest->no_of_days;
            }
            elseif($leaveType == 5){
                $remainingLeaveDays->unplanned_leave = $remainingLeaveDays->unplanned_leave + $leaveRequest->no_of_days;
            }
            elseif($leaveType == 6){
                $remainingLeaveDays->planned_leave = $remainingLeaveDays->planned_leave + $leaveRequest->no_of_days;
            }
            elseif($leaveType == 7){
                $remainingLeaveDays->restricted_leave = $remainingLeaveDays->restricted_leave + $leaveRequest->no_of_days;
            }
            elseif($leaveType == 8){
                $remainingLeaveDays->day_off = $remainingLeaveDays->day_off + $leaveRequest->no_of_days;
            }
            
            $update = $LeaveDays->save($remainingLeaveDays);
        }        
        return $update;
    }

    public static function getEmployeeNameFromId($id)
    {
        $employeesTable = TableRegistry::get('Employees');
        $employee = $employeesTable->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->first();

        return $employee->first_name." ".$employee->last_name;
    }

    public function getNameFromId($id) {
        $employeesTable = TableRegistry::get('Employees');
        $employee = $employeesTable->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->first();

        $name = $employee->first_name." ".$employee->last_name;
        return $name;
    }


//    public function getRemainingDays($UpdateRemainingLeave,$leaveType)
//    {
//         switch($leaveType){
//             case 1:{ return $UpdateRemainingLeave->sick_leave ; break; }
//             case 2:{ return $UpdateRemainingLeave->casual_leave; break; }
//             case 3:{ break; }
//             case 4:{ return $UpdateRemainingLeave->earned_leave;  break; }
//             case 5:{ return $UpdateRemainingLeave->unplanned_leave; break; }
//             case 6:{  return $UpdateRemainingLeave->planned_leave; break; }
//             case 7:{  return $UpdateRemainingLeave->restricted_leave;  break; }
//         }
//    }



}
