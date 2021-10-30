<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;

/**
 * Employees Model
 *
 * @property \App\Model\Table\EmpsTable|\Cake\ORM\Association\BelongsTo $Emps
 * @property \App\Model\Table\DesignationsTable|\Cake\ORM\Association\BelongsTo $Designations
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 * @property \App\Model\Table\EmployeeEducationTable|\Cake\ORM\Association\HasMany $EmployeeEducation
 * @property \App\Model\Table\EmployeeExperienceTable|\Cake\ORM\Association\HasMany $EmployeeExperience
 * @property \App\Model\Table\LeaveRequestsTable|\Cake\ORM\Association\HasMany $LeaveRequests
 *
 * @method \App\Model\Entity\Employee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeesTable extends Table
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

        $this->setTable('employees');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Designations', [
            'foreignKey' => 'designation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id'
        ]);
        $this->hasMany('EmployeeEducation', [
            'foreignKey' => 'employee_id'
        ]);
        $this->hasMany('EmployeeExperience', [
            'foreignKey' => 'employee_id'
        ]);
        $this->hasMany('LeaveRequests', [
            'foreignKey' => 'employee_id'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
        $this->hasMany('Salary', [
            'foreignKey' => 'employee_id',
            'propertyName' => 'employ_sal'
        ]);
        $this->hasMany('LeaveDays', [
            'foreignKey' => 'employee_id'
        ]);
        $this->hasMany('DesignationChanges', [
            'foreignKey' => 'employee_id'
        ]);

        $this->hasMany('ProcessDocumentations', [
            'foreignKey' => 'last_updated_by'
        ]);
        
        $this->hasMany('FormSubmissionsA', [
            'foreignKey' => 'employee_id',
            'className'=>'FormSubmissions'
        ]);
        
        $this->hasMany('FormSubmissionsB', [
            'foreignKey' => 'feedback_for',
            'className'=>'FormSubmissions'
        ]);


        $this->hasMany('ApprovedCompoff', [
            'foreignKey' => 'employee_id'
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
            ->requirePresence('first_name', 'create')
            ->notBlank('first_name', 'First name cannot be blank')
            ->notEmpty('first_name', 'Please Enter first name');

        $validator
            ->requirePresence('last_name', 'create')
            ->notBlank('last_name', 'Last name cannot be blank')
            ->notEmpty('last_name', 'Please enter last name');

        $validator
            ->email('personal_email')
            ->requirePresence('personal_email', 'create')
            ->notBlank('Personal Email cannot be blank')
            ->notEmpty('last_name', 'Please enter personal email');

        $validator
            ->requirePresence('office_email', 'create')
            ->notBlank('office_email', 'Office email cannot be blank')
            ->notEmpty('office_email', 'Please enter office Email');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password','Please enter password');

        $validator
            ->scalar('present_address')
            ->allowEmpty('present_address');

        $validator
            ->requirePresence('permanent_address', 'create')
            ->notBlank('permanent_address', 'Permanent address cannot be blank')
            ->notEmpty('permanent_address', 'Please enter permanent address');

        $validator
            ->integer('mobile_number')
            ->requirePresence('mobile_number', 'create')
            ->notBlank('mobile_number', 'Mobile number cannot be blank')
            ->notEmpty('mobile_number','Please enter mobile number');

        $validator
            ->integer('alternate_number')
            ->requirePresence('alternate_number', 'create')
            ->notBlank('alternate_number', 'Alternate number cannot be blank')
            ->notEmpty('alternate_number','Please enter alternate number');

        $validator
            ->integer('emergency_number')
            ->requirePresence('emergency_number', 'create')
            ->notBlank('emergency_number', 'Emergency number cannot be blank')
            ->notEmpty('emergency_number', 'Please enter emergency number');

        $validator
            ->requirePresence('country', 'create')
            ->notEmpty('country', 'Please Select a country');

        $validator
            ->requirePresence('office_location', 'create')
            ->notEmpty('office_location', 'Please select office location');

        $validator
            ->requirePresence('gender', 'create')
            ->notEmpty('gender', 'Please select gender');



        $validator
            ->scalar('maritial_status')
            ->maxLength('maritial_status', 20)
            ->allowEmpty('maritial_status');

        $validator
            ->scalar('blood_group')
            ->maxLength('blood_group', 8)
            ->allowEmpty('blood_group');

        $validator
            ->scalar('bank_name')
            ->allowEmpty('bank_name');

        $validator
            ->scalar('bank_account_number')
            ->maxLength('bank_account_number', 20)
            ->allowEmpty('bank_account_number');

        // $validator
        //     ->integer('salary')
        //     ->allowEmpty('salary');

        $validator
            ->scalar('tax_bracket')
            ->maxLength('tax_bracket', 50)
            ->requirePresence('tax_bracket', 'create')
            ->allowEmpty('tax_bracket');

        $validator
            ->scalar('languages')
            ->allowEmpty('languages');

        $validator
            ->requirePresence('max_qualification', 'create')
            ->notBlank('max_qualification', 'Max Qualification cannot be blank')
            ->notEmpty('max_qualification', 'Please enter max Qualification');

        $validator
            ->scalar('shift_type')
            ->maxLength('shift_type', 20)
            ->requirePresence('shift_type', 'create')
            ->notEmpty('shift_type', 'Shift time is required');

        $validator
            ->scalar('reporting_manager')
            ->maxLength('reporting_manager', 30)
            ->allowEmpty('reporting_manager');

        $validator
            ->scalar('mentor')
            ->maxLength('mentor', 30)
            ->allowEmpty('mentor');

        $validator
            ->requirePresence('date_of_joining', 'create')
            ->notEmpty('date_of_joining', 'Please enter date of joining');


        $validator
            ->scalar('source_of_hire')
            ->maxLength('source_of_hire', 20)
            ->allowEmpty('source_of_hire');

        $validator
            ->scalar('referred_by')
            ->maxLength('referred_by', 30)
            ->allowEmpty('referred_by');

        $validator
            ->scalar('work_phone')
            ->maxLength('work_phone', 20)
            ->requirePresence('work_phone', 'create')
            ->notEmpty('work_phone');

        $validator
            ->scalar('employment_type')
            ->maxLength('employment_type', 20)
            ->requirePresence('employment_type', 'create')
            ->notEmpty('employment_type');

        $validator
            ->requirePresence('confirmation_date', 'create')
            ->notEmpty('confirmation_date', 'Please enter a confirmation date');

        $validator
            ->requirePresence('designation_change', 'create')
            ->notEmpty('designation_change', 'Please enter designation change');

        $validator
            ->requirePresence('designation_change_date', 'create')
            ->notEmpty('designation_change_date', 'Please enter designation change date');

        $validator
            ->requirePresence('notice_period', 'create')
            ->notBlank('notice_period', 'Notice Period cannot be blank')
            ->notEmpty('notice_period', 'Please enter notice period');

        $validator
            ->scalar('reason')
            ->maxLength('reason', 30)
            ->allowEmpty('reason');

        $validator
            ->scalar('blacklisted')
            ->maxLength('blacklisted', 30)
            ->allowEmpty('blacklisted');

        $validator
            ->scalar('notes')
            ->allowEmpty('notes');

        $validator
            ->scalar('knowledge')
            ->requirePresence('knowledge', 'create')
            ->notEmpty('knowledge');

        $validator
            ->requirePresence('role_id', 'create')
            ->notEmpty('role_id', 'Please select role');

        $validator
            ->requirePresence('designation_id', 'create')
            ->notEmpty('designation_id', 'Please select designation');

        $validator
            ->scalar('hubstaff_name')
            ->allowEmpty('hubstaff_name');

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
        $rules->add($rules->existsIn(['designation_id'], 'Designations'));
        $rules->add($rules->existsIn(['department_id'], 'Departments'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['employee_id'],'FormSubmissionsA'));
        $rules->add($rules->existsIn(['feedback_for'],'FormSubmissionsB'));
        $rules->add($rules->existsIn(['employee_id'],'ApprovedCompoff'));
        $rules->add($rules->isUnique(['personal_email']));
        $rules->add($rules->isUnique(['office_email']));

        return $rules;
    }

    /**
     * converts employee form requests from string to date format
     * @param $employeeFormRequest is form request for employees
     * @return $employeeFormRequest returns data with formatted date
     */
    public function convertStringtoDateFormat($employeeFormRequest)
    {
        $employeeFormRequest['birth_date'] = date('Y-m-d', strtotime($employeeFormRequest['birth_date']));
        $employeeFormRequest['birth_date2'] = date('Y-m-d', strtotime($employeeFormRequest['birth_date2']));
        $employeeFormRequest['increment_date'] = date('Y-m-d', strtotime($employeeFormRequest['increment_date']));
        $employeeFormRequest['date_of_joining'] = date('Y-m-d', strtotime($employeeFormRequest['date_of_joining']));
        $employeeFormRequest['confirmation_date'] = date('Y-m-d', strtotime($employeeFormRequest['confirmation_date']));
        $employeeFormRequest['designation_change_date']  = date('Y-m-d', strtotime($employeeFormRequest['designation_change_date']));
        $employeeFormRequest['resignation_date'] = date('Y-m-d', strtotime($employeeFormRequest['resignation_date']));
        $employeeFormRequest['last_working_date'] = date('Y-m-d', strtotime($employeeFormRequest['last_working_date']));
        
        return $employeeFormRequest;
    }


    /** generates unique employee Id based on emplyee location
     * @param $employeeFormRequest is form request for employees
     * @return $employeeFormRequest returns unique employeeId
     */
    public function generateEmployerId($employeeFormRequest)
    {       
        if(isset( $employeeFormRequest['office_location'])) {
            $office = $employeeFormRequest['office_location'];
            $empId = $office.$this->generateRandomNo();
            $getEmployeesByOfficeLocation = $this->find('all', [
                'conditions' => [
                    'office_location' => $office    
                ],
                'fields' => ['emp_id']
            ])->toArray();
    
            $empIdsBasedOnofficeLocations = [];
            
            foreach ($getEmployeesByOfficeLocation as $key => $value) {
                $empIdsBasedOnofficeLocations[$key] = $value['emp_id'];
            }
    
            while(in_array($empId, $empIdsBasedOnofficeLocations)) {
                $empId = $office.$this->generateRandomNo();
            }
            return $empId;
        } else {
            return false;
        }

    }

    /**
     * genearate radom nos
     * @return $randomNo
     */
    public function generateRandomNo()
    {
        return rand(1,300);
    }

    /**
     * search employhees by keyword for designation, location, year of joining and status
     */
    public function searchEmployeesByKeyword($keyword)
    {   

        $results  = $this->find()
        ->matching('Designations', function ($q) use ($keyword) {
            return $q->where([
                'OR' => [
                    'Designations.title LIKE' => '%'.$keyword.'%',
                    'Employees.first_name LIKE' => '%'.$keyword.'%',
                    'Employees.last_name LIKE' =>  '%'.$keyword.'%',
                    'Employees.office_location LIKE' =>  '%'.$keyword.'%'
                ]
            ]);
        })
        ->contain(['Designations'])
        ->distinct(['Employees.id']);
        return $results;
    } 
    
    /**
     * Generate Employees by Id
     * @param $id is  id of the employee
     * @return $results 
     * 
     */
    public function getEmployeeById($id)
    {
        $results = $this->find('all',[
            'conditions' => [
                'id' => $id
            ]
        ])->toArray();

        return $results;
    }

    // check if old password match with given password
    public function checkPassword($inputPassword,$user)
    {
        return (new DefaultPasswordHasher)->check($inputPassword,$user->password);
    }

    // Hash new password for update
    public function hashPassword($inputPassword)
    {
        if (strlen($inputPassword) > 0) {
            return (new DefaultPasswordHasher)->hash($inputPassword);
        }
    }

    //check user is 18 years old or not
    public function checkOverEighteen($age)
    {
      $birthday = strtotime($age);
      if (time() < strtotime('+18 years', $birthday)) return false;
      return true;
    }

    //upload Identity
    public function uploadIdentity($fileInfo)
    {
        $splittedFileName = explode(".", $_FILES["identity_proof"]["name"]);
        $fileExtention = $splittedFileName[count($splittedFileName) - 1];
        
        $randomNumber = rand();
        $fileName = $randomNumber . '.' . $fileExtention;
        $uploadPath = 'file/';
        $uploadFile = $uploadPath.$fileName; 
        move_uploaded_file($_FILES['identity_proof']['tmp_name'], $uploadFile);
        return $fileName;
    }

    ////upload Picture
    public function uploadPicture($fileInfo)
    {
        $splittedFileName = explode(".", $_FILES["profile_pic"]["name"]);
        $fileExtention = $splittedFileName[count($splittedFileName) - 1];
        
        $randomNumber = rand();
        $fileName = $randomNumber . '.' . $fileExtention;
        $uploadPath = 'file/employessPicture/';
        $uploadFile = $uploadPath.$fileName; 
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadFile);
        return $fileName;
    }

    public function onLeaveCalculation($date)
    {
        $LeaveListTable = TableRegistry::get('EmpLeaves');
        $Employees = TableRegistry::get('Employees');
        $list = $LeaveListTable->find('all');

        $lastMonday = date('Y-m-d', strtotime('last monday'));       
        $nextFriday =  date('Y-m-d', strtotime('next friday'));
        $presentDay = date('D');
        $presentDate = Date('Y-m-d');

        if($presentDay == 'Mon'){
            $list = $list->select($LeaveListTable)->select($Employees)
                                    ->select([
                                            'max_date'=>$list->func()->max('date_to'),
                                            'min_date'=>$list->func()->min('date_from'),
                                            'number_of_days'=>$list->func()->sum('no_of_days')
                                           ])
                                   ->WHERE(['date_to >=' => $presentDate])
                                   ->WHERE(['is_approved' => 1])
                                   ->contain('Employees')
                                   ->where(['Employees.employment_status' => 1])
                                   ->group(['DATE_FORMAT(EmpLeaves.created,"%Y-%m-%d %H:%i")','employee_id','leave_reason','leave_type'])
                                   ->order(['min_date'=>"ASC"])
                                   ->toArray();
        } elseif($presentDay == 'Fri'){
            $list = $list->select($LeaveListTable)->select($Employees)
                                    ->select([
                                        'max_date'=>$list->func()->max('date_to'),
                                        'min_date'=>$list->func()->min('date_from'),
                                        'number_of_days'=>$list->func()->sum('no_of_days')
                                        ])
                                        ->WHERE(['date_to >=' => $presentDate])
                                   ->WHERE(['is_approved' => 1])
                                   ->contain('Employees')
                                   ->where(['Employees.employment_status' => 1])
                                   ->group(['DATE_FORMAT(EmpLeaves.created,"%Y-%m-%d %H:%i")','employee_id','leave_reason','leave_type'])
                                   ->order(['min_date'=>"ASC"])
                                   ->toArray();
        }else{
            $list = $list->select($LeaveListTable)->select($Employees)
                                    ->select([
                                        'max_date'=>$list->func()->max('date_to'),
                                        'min_date'=>$list->func()->min('date_from'),
                                        'number_of_days'=>$list->func()->sum('no_of_days')
                                        ])
                                        ->WHERE(['date_to >=' => $presentDate])
                                   ->WHERE(['is_approved' => 1])
                                   ->contain('Employees')
                                   ->where(['Employees.employment_status' => 1])
                                   ->group(['DATE_FORMAT(EmpLeaves.created,"%Y-%m-%d %H:%i")','employee_id','leave_reason','leave_type'])
                                   ->order(['min_date'=>"ASC"])
                                   ->toArray();

        }

        // $LeaveRequests=$LeaveRequestsAll->select($this->EmpLeaves)->select($this->Employees)->select([
        //     'max_date'=>$LeaveRequestsAll->func()->max('date_to'),
        //     'min_date'=>$LeaveRequestsAll->func()->min('date_from'),
        //     'number_of_days'=>$LeaveRequestsAll->func()->sum('no_of_days'),
        //     'group_id'=>'group_concat(EmpLeaves.id)'
        //     ])
        //     ->contain('Employees')
        //     ->order(['EmpLeaves.id' => 'desc'])
        //     ->WHERE(['status' => 1])
        //     ->WHERE(['emp_leave_cancellation'=> 0])
        //     ->group(['DATE_FORMAT(EmpLeaves.created,"%Y-%m-%d %H:%i")','employee_id','leave_reason','leave_type']);


        return $list;
    }

    //for Member Can update the profile
    public function convertStringtoDateFormatForMember($employeeFormRequest)
    {
        $employeeFormRequest['birth_date'] = date('Y-m-d', strtotime($employeeFormRequest['birth_date']));
        return $employeeFormRequest;
    }

}
