<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
/**
 * Employees Controller
 *
 *
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesController extends AppController
{
    private $Branch = '';

    /**
     * Index method to list active employess
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $loggedUser = $this->Auth->user('role_id');
        $keyword="";
        $employees=""; 
        $role = array(1,2,3);
        if (in_array($loggedUser, $role)) {
            $this->paginate = [
                'limit' =>15,
                'order' => [
                     'Employees.first_name' => 'asc'
                  ],
                'sortWhitelist' => [
                    'Employees.first_name',
                    'Designations.title',
                    'Employees.office_location'
                ],
                'conditions' => [
                'Employees.employment_status' => 1,
                 ]
            ];
            //debug($this->request->getQuery('search'));exit;
            $keyword='';
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $employees = $this->Employees->searchEmployeesByKeyword($keyword);
                $employees = $this->paginate($employees);
            } else {
                $employees = $this->paginate($this->Employees,[
                    'contain' => ['Designations', 'Departments']
                ]);
            }
            $branch = '';
            $this->set(compact('employees', 'keyword', 'branch'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(['action' => 'dashboard']);
        }
    }

    public function filter()
    {
        $keyword="";
        if ($this->request->is('post')) {
            $filterData = $this->request->getData();
            $branch = $filterData['branch'];
        } else if($this->request->getQuery('branch', '')){
            $branch = $this->request->getQuery('branch', '');
        }
        $filterData = $this->request->getData();
        $this->paginate = [
            'limit' => 200,
            'order' => [
                 'Employees.first_name' => 'asc'
              ],
            'sortWhitelist' => [
                'Employees.first_name',
                'Designations.title',
                'Employees.office_location'
            ],
            'conditions' => [
                'Employees.employment_status' => 1,
                'Employees.office_location' => $branch,
             ]
        ];
        if (!empty($this->request->getQuery('search'))) {
            $keyword = $this->request->getQuery('search');
            $employees = $this->Employees->searchEmployeesByKeyword($keyword);
            $employees = $this->paginate($employees);
        } else {
            $employees = $this->paginate($this->Employees,[
                'contain' => ['Designations', 'Departments']
            ]);
        }
        $this->set(compact('employees', 'keyword', 'branch'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loggedUser = $this->Auth->user('role_id');
        $employeeName = $this->Auth->user('first_name'). ' '.$this->Auth->user('last_name');

        $role = array(1,2,3);
        if (in_array($loggedUser, $role)) {
            $employee = $this->Employees->get($id,[
                'contain' => ['Designations', 'Departments','Salary','LeaveDays','DesignationChanges']
            ]);
            $reportingTeam= $this->Employees->Departments->getDepartmentById($employee->reporting_team);
            $reportingManager = $this->Employees->getEmployeeById($employee->reporting_manager);

            if(isset($reportingManager) && !empty($reportingManager)) {
                $reportingManager = $reportingManager[0]['first_name'].' '.$reportingManager[0]['last_name'];
            } else {
                $reportingManager = '';
            }

            if(!empty($employee->salary)){
                foreach($employee->salary as $salary){
                    $employeeSalary['id']     = $salary['id'];
                    $employeeSalary['salary'] = $salary['salary_amount'];
                    $employeeSalary['approval'] = $salary['is_approved'];
                    $employeeSalary['Reason'] = $salary['reason'];
                }
            } else {
                $employeeSalary['approval'] = " ";
            }

            $isLeaveAdded = count($employee->leave_days);
            if(!empty($employee->leave_days)){
                foreach($employee->leave_days as $leaveDay){
                    $leaveDays['id']     = $leaveDay['id'];
                }
            } else {
                $leaveDays['id'] = " ";
            }

            $this->set(compact('employee', 'reportingTeam', 'reportingManager','employeeSalary','employeeName','isLeaveAdded','leaveDays'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(['action' => 'dashboard']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,3);
        if (in_array($loggedUser, $role)) {
            $employee = $this->Employees->newEntity();
            $designations = $this->Employees->Designations->find('list')->WHERE(['status'=>1]);
            $designations = $designations->toArray();
            $designations[''] = 'Select Designation';

            $departments = $this->Employees->Departments->find('list')->WHERE(['status'=>1]);
            $departments = $departments->toArray();
            $departments[''] = 'Select Department';

            $role = $this->Employees->Roles->find('list');
            $role = $role->toArray();
            $role[''] = 'Select Role';
            $roleWithouSuperAdmin = $role;
            if($roleColumn = array_search('Super Admin', $roleWithouSuperAdmin)){
                unset($roleWithouSuperAdmin[$roleColumn]);
            }

            $roleWithouHrAdmin = $roleWithouSuperAdmin;
            if($roleColumn = array_search('Hr Admin', $roleWithouHrAdmin)){
                unset($roleWithouHrAdmin[$roleColumn]);
            }

            $reportingTeam = $departments;
            $reportingTeam[''] = 'Select Reporting Team';

            $reportingManager = $this->Employees->find('list',[
                'keyField' => 'id',
                'valueField' => function ($e) {
                    return $e->first_name . ' ' . $e->last_name;
                },
                'conditions' => [
                    'reporting_manager_responsibilities' => 1
                ]
            ])->toArray();
            $reportingManager[''] = 'Select Reporting Manager';


            if ($this->request->is('post')) {
               if(($loggedUser != 1) && ($this->request->getData() == 1)){

                    $this->Flash->error(__('You are not authorized to add superadmin.'));
                }
                $employeeFormRequest = $this->request->getData();
                $employeeFormRequest = $this->Employees->convertStringtoDateFormat($employeeFormRequest);
                $employeeFormRequest["emp_id"] = $this->Employees->generateEmployerId($employeeFormRequest);
                $employee = $this->Employees->patchEntity($employee, $employeeFormRequest);
                if(!empty($_FILES)){
                    $fileName =  $this->Employees->uploadIdentity($_FILES);
                    $employee->identity_proof = $fileName;
                }

                //picture upload
                if(!empty($_FILES)){
                    $fileName =  $this->Employees->uploadPicture($_FILES);
                    $employee->profile_pic = $fileName;
                }
                   
                if ($saveEmployee = $this->Employees->save($employee)) {
                    $employeeId = $saveEmployee->id;
                    $this->loadModel('DesignationChanges');
                    $designationChange = $this->DesignationChanges->newEntity();

                    $designationChange->employee_id = $employeeId;
                    $designationChange->designation_change = $this->request->getData['designation_change'];
                    $designationChange->change_date = $this->request->getData['designation_change_date'];
                    $this->DesignationChanges->save($designationChange);

                    $designationEmployee = $this->Employees->Designations->incrementDesiginationEmployee($this->request->getData(['designation_id']));
                    $departmentEmployee = $this->Employees->Departments->incrementDepartmentEmployee($this->request->getData(['department_id']));
                    $this->Flash->success(__('The employees data has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The employee could not be saved. Please, try again.'));
            }
            $this->set(compact('employee', 'designations', 'departments', 'reportingManager', 'reportingTeam','role','roleWithouSuperAdmin','roleWithouHrAdmin'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(['action' => 'dashboard']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,3);
        if (in_array($loggedUser, $role)) {
            $employee = $this->Employees->get($id,[
                'contain' => ['DesignationChanges']
            ]);
            $designations = $this->Employees->Designations->find('list')->WHERE(['status'=>1]);
            $designations = $designations->toArray();
            $designations[''] = 'Select Designation';
            $departments = $this->Employees->Departments->find('list')->WHERE(['status'=>1]);
            $departments = $departments->toArray();
            $departments[''] = 'Select Department';

            $role = $this->Employees->Roles->find('list');
            $role = $role->toArray();
            $role[''] = 'Select Role';

            $roleWithouSuperAdmin = $role;
            if($roleColumn = array_search('Super Admin', $roleWithouSuperAdmin)){
                unset($roleWithouSuperAdmin[$roleColumn]);
            }

            $roleWithouHrAdmin = $roleWithouSuperAdmin;
            if($roleColumn = array_search('Hr Admin', $roleWithouHrAdmin)){
                unset($roleWithouHrAdmin[$roleColumn]);
            }

            $reportingTeam = $departments;
            $reportingTeam[''] = 'Select Reporting Team';
            $reportingManager = $this->Employees->find('list',[
                                    'keyField' => 'id',
                                    'valueField' => function ($e) {
                                        return $e->first_name . ' ' . $e->last_name;
                                    },
                                    'conditions' => [
                                        'reporting_manager_responsibilities' => 1
                                    ]
                                ])->toArray();

            $reportingManager[''] = 'Select Reporting Manager';

            if ($this->request->is(['patch', 'post', 'put'])) {

                if(($loggedUser != 1) && ($this->request->data == 1)){
                    $this->Flash->error(__('You are not authorized to add superadmin.'));
                }

                $employeeFormRequest = $this->request->getData();
                $employeeFormRequest = $this->Employees->convertStringtoDateFormat($employeeFormRequest);
                $employee = $this->Employees->patchEntity($employee, $employeeFormRequest);
                $employee->is_pm =  $employeeFormRequest['is_pm'];

                if(!empty($this->request->data['identity_proof']['name'])){
                    $fileName =  $this->Employees->uploadIdentity($this->request->data['identity_proof']);
                    $employee->identity_proof = $fileName;
                }

                if ($this->Employees->save($employee)) {
                    $this->loadModel('DesignationChanges');
                    $isAvailableThisDesignation = $this->DesignationChanges->find('all',array('conditions'=> array(
                                                    'employee_id' => $id,
                                                    'designation_change' => $this->request->data['designation_change']
                                                )))->toArray();
                    if (empty($isAvailableThisDesignation)) {
                        $designationChange = $this->DesignationChanges->newEntity();

                        $designationChange->employee_id = $id;
                        $designationChange->designation_change = $this->request->data['designation_change'];
                        $designationChange->change_date = $this->request->data['designation_change_date'];
                        $this->DesignationChanges->save($designationChange);
                    }
                    $this->Flash->success(__('The employees data has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The employees data could not be saved. Please, try again.'));
            }
            $this->set(compact('employee', 'designations', 'departments', 'reportingManager', 'reportingTeam','role','roleWithouSuperAdmin','roleWithouHrAdmin'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(['action' => 'dashboard']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,3);
        if (in_array($loggedUser, $role)) {
            $employee = $this->Employees->get($id);
            $employee->employment_status = 0;
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been deleted.'));
            } else {
                $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(['action' => 'dashboard']);
        }
    }


    /**
     *
     *Uses custom login layout
     *Authenticates and redirects to pages/home on successful login
     *@throws error flash error message on failed login
    */
    public function login()
    {
        $this->viewBuilder()->setLayout('login');

        if ($this->request->getSession()->read('Auth.User')) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->request->is('post')) {
            $employee = $this->Auth->identify();
            if ($employee) {
                $this->Auth->setUser($employee);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error('Your username or password is incorrect.');
            }
        }
        $employee = $this->Employees->newEntity();

        $this->set(compact('employee'));
    }

    /**
     * Logout method closes the session and redirects to login page
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }


    /**
     * Index method to list inactive employess
     *
     * @return \Cake\Http\Response|void
     */
    public function inactive()
    {
        $keyword="";
        $this->paginate = [
            'limit' =>15,
            'order' => [
                 'Employees.first_name' => 'asc'
              ],
            'sortWhitelist' => [
                'Employees.first_name',
                'Designations.title',
                'Employees.office_location'
            ],
            'conditions' => [
            'Employees.employment_status' => 0,
             ]
        ];

        if (!empty($this->request->getQuery('search'))) {
            $keyword = $this->request->getQuery('search');
            $employees = $this->Employees->searchEmployeesByKeyword($keyword);
            $employees = $this->paginate($employees);
        }

        else {
            $employees = $this->paginate($this->Employees,[
                'contain' => ['Designations', 'Departments']
            ])
            ;
        }

        $this->set(compact('employees', 'keyword'));
    }

    /**
     * @throws \Exception
     */

    function dateDiffInDays($date1, $date2)
    {
        // Calulating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);

        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400));
    }

    public function dashboard()
    {

        $this->loadModel("Forms");
        $announcements = TableRegistry::get('Announcements');
        $results =  $announcements->find('all')->order(['created DESC'])->toArray();
        $date = date('Y-m-d');
        $currentDay = date('d',strtotime($date));
        $currentMonth  = date('m' , strtotime($date));
        // adding new
        $addNewTag = array();
        foreach ($results as $key => $value) {
            $created = date('Y-m-d',strtotime($value['created']));
            if( $created <= date('Y-m-d') ){
                $daysDiff = $this->dateDiffInDays($created,date('Y-m-d'));
                if($daysDiff < 7){
                    $addNewTag[] = $value['id'];
                }
            }
        }
        $employeeAnniversary = [];
        $todayDate = new \DateTime($date);
        foreach ($results as $key => $value ) {
            if((date('Y-m-d', strtotime($value['end_date'])) < $date)){
                unset($results[$key]);
            }
        }

        $employeeBirthdays = $this->Employees->find('all',[
            'conditions' => [
                'DAY(birth_date)' => $currentDay,
                'MONTH(birth_date)' => $currentMonth,
                'employment_status' => 1
            ],
            'fields' => ['first_name', 'last_name', 'birth_date']
        ])->toArray();

        $employees = $this->Employees->find('all',[
            'conditions' => [
              'employment_status' => 1
            ],
            'fields' => ['first_name', 'last_name', 'date_of_joining']])->toArray();

        foreach($employees as $employee)
        {

            if(date('m', strtotime($employee['date_of_joining'])) == date('m') &&
            date('d', strtotime($employee['date_of_joining'])) >= date('d', strtotime("previous monday")) &&
            date('d', strtotime($employee['date_of_joining'])) <= date('d', strtotime("next sunday")) )
            {
                $diff = $employee['date_of_joining']->diff($todayDate);
                if($diff->y > 1)
                {
                    $employee['years'] = $diff->y;//($curYears - $empYears);
                    array_push($employeeAnniversary, $employee);
                }
            }
        }

        $role_id=$this->Auth->user("role_id");
        $empid=$this->Auth->user("id");
        $filter = ['FormVisibility.role_id' => $role_id];
        $date=date("Y-m-d");
          $formResult=$this->Forms
                         ->find('all')
                         ->contain(['FormFields',
                                    'FormFeedbackFor'=> function ($q) {return $q->select(['FormFeedbackFor.form_id','FormFeedbackFor.employee_id']);},
                                    'FormVisibility' => function ($query) use ($role_id) {
                                             return $query->where(['FormVisibility.role_id' => $role_id]);
                                        },
                                   ])
                         ->where(['available_from <='=>$date,'available_to >='=>$date,'status'=>1]); 
        $employeeOnLeave = $this->Employees->onLeaveCalculation($todayDate);
        // $employeeOnLeave = []; 
        $this->set(compact('results', 'addNewTag', 'employeeBirthdays', 'employeeAnniversary','employeeOnLeave','empid','formResult'));
    }
    public function profile()
    {
        $id = ($this->Auth->user('id'));
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,3,4,5,6);
        if(in_array($loggedUser, $role)) {
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

            if(!empty($employee->employ_sal)){
                foreach($employee->employ_sal as $salary){
                    $employeeSalary['id']     = $salary['id'];
                    $employeeSalary['salary'] = $salary['salary_amount'];
                    $employeeSalary['approval'] = $salary['is_approved'];
                    $employeeSalary['Reason'] = $salary['reason'];
                }
            } else {
                $employeeSalary['approval'] = " ";
            }

            $this->set(compact('employee', 'reportingTeam', 'reportingManager','employeeSalary'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(['action' => 'dashboard']);
        }
    }

    //change password
    public function changePassword($id = null)
    {
        if($this->request->is('PUT')){
            $userId = $id;
            $getUserData = $this->Employees->get($id);
            $oldPassword = $this->request->data(['old_password']);
            $checkOldPasswordMatched = $this->Employees->checkPassword($oldPassword,$getUserData);
            if($checkOldPasswordMatched){
                if(!empty($this->request->data(['new_password'])) && !empty($this->request->data(['confirm_password']))){
                    if($this->request->data(['new_password']) == $this->request->data(['confirm_password'])){
                        $hashPassword = $this->Employees->hashPassword($this->request->data(['new_password']));
                        $this->Employees->updateAll(array("password" => $hashPassword), array("id" => $id));
                        $this->Flash->success(__("Password updated successfully."));
                        return $this->redirect(['action' => 'profile']);
                    }
                    else{
                        $this->Flash->error(__("New Password and Confirm Password needs to match."));
                        return $this->redirect(['action' => 'profile']);
                    }
                }
                else{
                    $this->Flash->error(__("New Password and Confirm Password can't be empty."));
                    return $this->redirect(['action' => 'profile']);
                }
            }
            else{
                $this->Flash->error(__("Old password is not matched"));
                return $this->redirect(['action' => 'profile']);
            }
        }
        else{
            return $this->redirect(['action' => 'profile']);        }
    }

    public function forgot()
    {
        $this->viewBuilder()->setLayout('login');

        if ($this->request->getSession()->read('Auth.User')) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->request->is('post')) {
            $formData = $this->request->getData();

            $userEmail = $formData['office_email'];
            $invokedUser = $this->Employees->find('all')->where(['office_email' => $userEmail])->first();
            if ($invokedUser){
                $this->loadModel('PasswordRetrieve');
                $objPasswordRetrieve = $this->PasswordRetrieve->newEntity();
                $dboPasswordRetrieve = $this->PasswordRetrieve->find('all')->where(['user_email' => $userEmail])->first();

                if ($dboPasswordRetrieve){
                    $this->PasswordRetrieve->updateAll(array('sec_token' => md5($invokedUser->office_email), 'request_date_time' => date('Y-m-d H:s:i'), 'change_date_time' => null), array('user_email' => $invokedUser->office_email));
                    $emailSender = array('profile' => 'default', 'senderEmail' => 'no-reply@sjinnovation.com', 'senderName' => 'SJ Connect', 'toEmail' => $userEmail, 'format' => 'html', 'template' => 'forgot', 'subject' => 'Password Retrieval', 'token' => md5($invokedUser->office_email), 'userEmail' => $dboPasswordRetrieve->user_email, 'userId' => $dboPasswordRetrieve->user_id, 'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png', );
                    $this->sendEmail($emailSender);

                    $this->Flash->success(__('An email has been sent to your email. Please look into the SPAM folder too.'));
                    $this->redirect('/');
                } else {
                    $objPasswordRetrieve->user_email = $invokedUser->office_email;
                    $objPasswordRetrieve->user_id = $invokedUser->id;
                    $objPasswordRetrieve->sec_token = md5($invokedUser->office_email);
                    $objPasswordRetrieve->request_date_time = date('Y-m-d H:s:i');
                    $objPasswordRetrieve->change_date_time = null;

                    if ($this->PasswordRetrieve->save($objPasswordRetrieve)) {

                        $emailSender = array('profile' => 'default', 'senderEmail' => 'no-reply@sjinnovation.com', 'senderName' => 'SJ Connect', 'toEmail' => $userEmail, 'format' => 'html', 'template' => 'forgot', 'subject' => 'Password Retrieval', 'token' => $objPasswordRetrieve->sec_token, 'userEmail' => $objPasswordRetrieve->user_email, 'userId' => $objPasswordRetrieve->user_id, 'imageUrl' => 'https://marketing-image-production.s3.amazonaws.com/uploads/c1e9ad698cfb27be42ce2421c7d56cb405ef63eaa78c1db77cd79e02742dd1f35a277fc3e0dcad676976e72f02942b7c1709d933a77eacb048c92be49b0ec6f3.png', );
                        $this->sendEmail($emailSender);

                        $this->Flash->success(__('An email has been sent to your email. Please look into the SPAM folder too.'));
                        $this->redirect('/');
                    } else {
                        $this->Flash->error('Something went wrong with the database, please try again later.');
                        $this->redirect('/');
                    }
                }
            } else {
                $this->Flash->error('Email doesnt exists in our database.');
                $this->redirect('/');
            }
        }

        $employee = $this->Employees->newEntity();

        $this->set(compact('employee'));
    }

    public function retrieve()
    {
        $this->loadModel('PasswordRetrieve');
        if($this->request->is('post')){

            $user_email = $this->request->getData();

            if($user_email['repeat'] === $user_email['password']){

                $_Retrieve = $this->PasswordRetrieve->find('all')->where(['user_email' => $user_email['office_email'], 'user_id' => $user_email['userId']])->first();
                $_Retrieve->sec_token = null;
                $_Retrieve->request_date_time = null;
                $_Retrieve->change_date_time = null;
                $this->PasswordRetrieve->save($_Retrieve);

                $currentUser = $this->Employees->find('all')->where(['office_email' => $user_email['office_email'], 'id' => $user_email['userId']])->first();
                if ($currentUser){
                    $hashPassword = $this->Employees->hashPassword($user_email['password']);
                    $this->Employees->updateAll(array("password" => $hashPassword), array("id" => $user_email['userId']));
                    $this->Flash->success(__("Password updated successfully."));
                    return $this->redirect('/');
                }
            } else {
                $this->Flash->error('Password and Confirm password do not match.');
                $this->viewBuilder()->setLayout('login');

                if ($this->request->getSession()->read('Auth.User')) {
                    return $this->redirect($this->Auth->redirectUrl());
                }

                $employee = $this->Employees->newEntity();

                $this->set(['employee' => $employee, 'office_email' => $user_email['office_email'], 'userId' => $user_email['userId'], 'token' => $user_email['token']]);
            }

        } else {
            $userEmail = $this->request->getQuery('email');
            $token = $this->request->getQuery('token');
            $userId = $this->request->getQuery('userId');
            $_Retrieve = $this->PasswordRetrieve->find('all')->where(['user_email' => $userEmail, 'sec_token' => $token, 'user_id' => $userId])->first();

            if ($_Retrieve){
                $date = strtotime($_Retrieve->request_date_time) + 86400;
                if(time() < $date) {

                    $this->viewBuilder()->setLayout('login');

                    if ($this->request->getSession()->read('Auth.User')) {
                        return $this->redirect($this->Auth->redirectUrl());
                    }

                    $employee = $this->Employees->newEntity();

                    $this->set(['employee' => $employee, 'office_email' => $userEmail, 'userId' => $userId, 'token' => $token]);
                } else {
                    $_Retrieve->sec_token = null;
                    $_Retrieve->request_date_time = null;
                    $_Retrieve->change_date_time = null;
                    $this->PasswordRetrieve->save($_Retrieve);

                    $this->Flash->error('Token has expired.');
                    $this->redirect('/');
                }
            } else {
                $this->Flash->error('Invalid Token provided.');
                $this->redirect('/');
            }
        }
    }

    private function sendEmail($emailObject)
    {
        $emailSender = new Email($emailObject['profile']);
        $emailSender->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
            ->setto($emailObject['toEmail'])
            ->setEmailFormat($emailObject['format'])
            ->setTemplate($emailObject['template'])
            ->setSubject($emailObject['subject'])
            ->setViewVars(['token' => $emailObject['token'], 'useremail' => $emailObject['userEmail'], 'userId' => $emailObject['userId'], 'imageUrl' => $emailObject['imageUrl']])
            ->send();
    }

    public function test()
    {
        $this->autoRender = false;
        if ($this->request->is(['ajax'])){
        $employee = $this->Employees->newEntity();
        $employee->first_name = $this->request->getData('first_name');
        $employee->last_name = $this->request->getData('last_name');
        $employee->office_email = $this->request->getData('office_email');
        $employee->gender = $this->request->getData('gender');
        $employee->permanent_address = $this->request->getData('permanent_address');
        $employee->country = $this->request->getData('country');
        $employee->office_location = $this->request->getData('office_location');
        $employee->mobile_number = $this->request->getData('mobile_number');
        $employee->alternate_number = $this->request->getData('alternate_number');
        $employee->emergency_number = $this->request->getData('emergency_number');
        $employee->max_qualification = $this->request->getData('max_qualification');
        $this->Employees->save($employee);
        $this->response->body(json_encode($employee));
        return $this->response;
       }
    }

    /**
     * Member Can Edit Profile method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function memberCanEdit($id = null)
    {
        $loggedUser = $this->Auth->user('id');
        $employee = $this->Employees->get($loggedUser);
        if ($this->request->is(['patch', 'post', 'put'])){

            $employeeFormRequest = $this->request->getData();
            $employeeFormRequest = $this->Employees->convertStringtoDateFormatForMember($employeeFormRequest);
            $employee = $this->Employees->patchEntity($employee, $employeeFormRequest);

             if(!empty($this->request->data['profile_pic']['name'])){
                    $fileName =  $this->Employees->uploadPicture($this->request->data['profile_pic']);
                    $employee->profile_pic = $fileName;
                }
            if ($this->Employees->save($employee))
            {
                $this->Flash->success(__('The employee has been saved.'));
                return $this->redirect(['action' => 'dashboard']);
            }
            else
            {
                $this->Flash->error(__('Your session has timed out.'));
            }
        }
     $this->set(compact('employee'));
    }
}

