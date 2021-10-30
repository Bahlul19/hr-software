<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * LeaveRequests Model
 *
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\LeaveRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\LeaveRequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LeaveRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeaveRequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeaveRequest|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeaveRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LeaveRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeaveRequest findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeaveRequestsTable extends Table
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

        $this->setTable('leave_requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
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
            ->decimal('no_of_days')
            ->requirePresence('no_of_days', 'create')
            ->notEmpty('no_of_days');


        $validator
            ->scalar('leave_reason')
            ->requirePresence('leave_reason', 'create')
            ->notEmpty('leave_reason');

        $validator
            ->scalar('reliever')
            ->requirePresence('reliever', 'create')
            ->notEmpty('reliever');

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

    /**
     * Search by name,employee and lead
     * @param $keyword entered in search box
     * @return $results returns search results
     */
    public function searchByName($keyword)
    {
        $results = $this->find(
            'all', array('conditions' => [['CONCAT(LeaveRequests.employee_name) like' => '%' . $keyword . '%']
        ]
        ));

        return $results;
    }

    /**
     * converts Leave Request form requests from string to date format
     * @param $LeaveRequestsForm is form request for Leave Request
     * @return $LeaveRequestsForm returns data with formatted date
     */
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
        $reportingManagerEmail = $employees->find('all')->select('office_email')->WHERE(['id'=>$id]);
        $email = array();
        foreach ($reportingManagerEmail as $rme){
            $email = $rme['office_email'];
        }
        return $email;
    }

    //for getting the user who has applied for leave request.
    public function leaveRequestUser($id = null)
    {
        $employees = TableRegistry::get('Employees');
        $LeaveRequest=TableRegistry::get('leave_requests');
        $userId = $LeaveRequest->find()->select('employee_id')->WHERE(['id' => $id]);
        $leaveRequestUserEmail = $employees->find('all')->select('office_email')->WHERE(['id'=>$userId]);
        $email = array();
        foreach ($leaveRequestUserEmail as $lrue){
            $email = $lrue['office_email'];
        }
        return $email;
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

    // function for Full day approval
    public function isFullApproved($getValue,$isApprove,$leaveType,$employeeName)
    {
        if($isApprove == 1){
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
            $getValue['is_approved']      = $isApprove;

        } else {
            $getValue['is_approved']      = $isApprove;
        }
        return $getValue;
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

    //remaining calculation for taking fullday Leave
    public function remainingCalculateFull($CheckApprovalDecision,$getLeaveDays)
    {

        if ($CheckApprovalDecision['leave_type'] == 1){
            $getLeaveDays['sick_leave'] -= $CheckApprovalDecision['sick_leave_taken'];
        }
        if ($CheckApprovalDecision['leave_type'] == 2){
            $getLeaveDays['casual_leave'] -= $CheckApprovalDecision['casual_leave_taken'];
        }
        if ($CheckApprovalDecision['leave_type'] == 4){
            $getLeaveDays['earned_leave'] -= $CheckApprovalDecision['earned_leave_taken'];
        }
        if ($CheckApprovalDecision['leave_type'] == 5){
            $getLeaveDays['unplanned_leave'] -= $CheckApprovalDecision['unplanned_leave_taken'];
        }
        if ($CheckApprovalDecision['leave_type'] == 6){
            $getLeaveDays['planned_leave'] -= $CheckApprovalDecision['planned_leave_taken'];
        }
        if ($CheckApprovalDecision['leave_type'] == 7){
            $getLeaveDays['restricted_leave'] -= $CheckApprovalDecision['restricted_leave_taken'];
        }
        if ($CheckApprovalDecision['leave_type'] == 8){
            $getLeaveDays['day_off'] -= $CheckApprovalDecision['day_off_taken'];
        }
        return $getLeaveDays;
    }

    //remaining calculation for taking halfday Leave
    public function remainingCalculateHalf($CheckApprovalDecision,$getLeaveDays)
    {
        if ($CheckApprovalDecision['leave_type'] == 1){
            $getLeaveDays['sick_leave'] -= 0.5;
        }
        if ($CheckApprovalDecision['leave_type'] == 2){
            $getLeaveDays['casual_leave'] -= 0.5;
        }
        if ($CheckApprovalDecision['leave_type'] == 4){
            $getLeaveDays['earned_leave'] -= 0.5;
        }
        if ($CheckApprovalDecision['leave_type'] == 5){
            $getLeaveDays['unplanned_leave'] -= 0.5;
        }
        if ($CheckApprovalDecision['leave_type'] == 6){
            $getLeaveDays['unplanned_leave'] -= 0.5;
        }
        if ($CheckApprovalDecision['leave_type'] == 7){
            $getLeaveDays['restricted_leave'] -= 0.5;
        }
        if ($CheckApprovalDecision['leave_type'] == 8){
            $getLeaveDays['day_off'] -= 0.5;
        }
        return $getLeaveDays;
    }


    //  function for full day leave
    public function fullDayLeave($employeeId,$leave_type,$leaveTypeName)
    {
        $LeaveRequests = TableRegistry::get('LeaveRequests');
        $sick_result = $LeaveRequests->find()->select($leaveTypeName)->WHERE(['employee_id'=>$employeeId])->WHERE(['leave_type'=>$leave_type])->WHERE(['half_day'=>0])->WHERE(['status'=>1]);
        $sick_taken = 0;
        foreach($sick_result as $r){
            $sick_taken+=$r[$leaveTypeName];
        }
        return $sick_taken;
    }

    // function for half day leave
    public function halfDayLeave($employeeId,$leave_type)
    {
        $LeaveRequests = TableRegistry::get('LeaveRequests');
        $half_sick_result_1st_half= 0;
        $half_sick_result_2nd_half= 0;

        $half_sick_result_1st_half = $LeaveRequests->find()->select('half_day_taken')->WHERE(['employee_id'=>$employeeId])->WHERE(['leave_type'=>$leave_type])->WHERE(['half_day_taken'=>1])->WHERE(['status'=>1])->count();
        $half_sick_result_2nd_half = $LeaveRequests->find()->select('half_day_taken')->WHERE(['employee_id'=>$employeeId])->WHERE(['leave_type'=>$leave_type])->WHERE(['half_day_taken'=>2])->WHERE(['status'=>1])->count();

        $half_sick_result = $half_sick_result_1st_half + $half_sick_result_2nd_half;

        $half_sick_taken = 0;
        if(!empty($half_sick_result)){
            $half_sick_taken+=(0.5*$half_sick_result);
        }

        return $half_sick_taken;
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

    public function totalLeaveForGoa($unplanned_taken,$planned_taken,$restricted_taken)
    {
        return $total_Leave = $unplanned_taken + $planned_taken + $restricted_taken;
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

}