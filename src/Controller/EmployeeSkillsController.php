<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;

/**
 * EmployeeSkills Controller
 *
 * @property \App\Model\Table\EmployeeSkillsTable $EmployeeSkills
 *
 * @method \App\Model\Entity\EmployeeSkill[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeSkillsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('skills');
        $this->loadModel('skillLevels');
        $this->loadModel('SkillCategories');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $role = $this->Auth->user('role_id');
        $allowed = array(1,2);
        if(in_array($role, $allowed))
        {
            $employeeSkills=$this->EmployeeSkills->find('all', [
            'contain' => ['Skills','SkillLevels','Employees']
            ])->where(['EmployeeSkills.status'=> '1'])->order(['EmployeeSkills.created' => 'DESC'])->toArray();
            foreach($employeeSkills as $emp){
            $get_name=$this->EmployeeSkills->find()->select(['emp.first_name', 'emp.last_name'])
            ->join([
                'table' => 'employees',
                'alias' => 'emp',
                'type' => 'LEFT',
                'conditions' => [
                    'emp.id = EmployeeSkills.updated_by',
                ]
            ])->where([
                'EmployeeSkills.status'=> '1',
                'EmployeeSkills.id'=> $emp->id,
                ])->first();
            //debug($get_name['emp']['first_name']);
            $emp['updated_by_name']=$get_name['emp']['first_name']." ".$get_name['emp']['last_name'];
        }
        $this->set(compact('employeeSkills'));
    }
    else{
        $this->Flash->error(__('You dont have access to view this page.'));
        return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
    }
    }

    public function mySkills()
    {
        $role = $this->Auth->user('role_id');
        $allowed = array(1,2,3,4,5,6);
        $user=$this->Auth->user('id');
        if(in_array($role, $allowed))
        {
            $employeeSkills=$this->EmployeeSkills->find('all', [
                'contain' => ['Skills','SkillLevels']
            ])->where(['EmployeeSkills.employee_id'=> $this->Auth->user('id')])->order(['EmployeeSkills.created' => 'DESC'])->toArray();
            foreach($employeeSkills as $emp){
                //debug($emp->id);
                $get_name=$this->EmployeeSkills->find()->select(['emp.first_name', 'emp.last_name'])
                ->join([
                    'table' => 'employees',
                    'alias' => 'emp',
                    'type' => 'LEFT',
                    'conditions' => [
                        'emp.id = EmployeeSkills.updated_by',
                    ]
                ])->where([
                    'EmployeeSkills.employee_id'=> $this->Auth->user('id'),
                    'EmployeeSkills.id'=> $emp->id,
                    ])
                ->first();
                //debug($get_name['emp']['first_name']);
                $emp['updated_by_name']=$get_name['emp']['first_name']." ".$get_name['emp']['last_name'];
                //debug($get_name);
            }
            //exit;
            $this->set(compact('employeeSkills','user'));
        }
        else{
            $this->Flash->error(__('You dont have access to view this page.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    public function rejectedIndex()
    {
        $role = $this->Auth->user('role_id');
        $allowed = array(1,2);
        if(in_array($role, $allowed))
        {
            $employeeSkills=$this->EmployeeSkills->find('all', [
                'contain' => ['Skills','SkillLevels','Employees']
            ])->where(['EmployeeSkills.status'=> '0'])->order(['EmployeeSkills.created' => 'DESC'])->toArray();
            foreach($employeeSkills as $emp){
                $get_name=$this->EmployeeSkills->find()->select(['emp.first_name', 'emp.last_name'])
                ->join([
                    'table' => 'employees',
                    'alias' => 'emp',
                    'type' => 'LEFT',
                    'conditions' => [
                        'emp.id = EmployeeSkills.updated_by',
                    ]
                ])->where([
                    'EmployeeSkills.status'=> '0',
                    'EmployeeSkills.id'=> $emp->id,
                ])->first();
                //debug($get_name['emp']['first_name']);
                $emp['updated_by_name']=$get_name['emp']['first_name']." ".$get_name['emp']['last_name'];
            }
            $this->set(compact('employeeSkills'));
        }
        else{
            $this->Flash->error(__('You dont have access to view this page.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    public function approvalIndex()
    {
        $role = $this->Auth->user('role_id');
        $allowed = array(1,2,3,5,6);
        if(in_array($role, $allowed))
        {

            
            $employeeSkills=$this->EmployeeSkills->find('all', [
                                  'contain' => ['Skills','SkillLevels','Employees']
                                  ])
                                  ->where(['EmployeeSkills.status'=> '2'])
                                  ->order(['EmployeeSkills.created' => 'DESC'])
                                  ->toArray();

            $this->set(compact('employeeSkills'));
        }
        else{
            $this->Flash->error(__('You dont have access to view this page.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    public function approveSkill($id){
        $role = $this->Auth->user('role_id');
        $allowed = array(1,2);
        if(in_array($role, $allowed))
        {
            $this->autorender = false;
            $employeeSkill = $this->EmployeeSkills->get($id, [
                'contain' => ['Skills','SkillLevels','Employees']
            ]);
            $employeeSkill->status=1;
            $employeeSkill->updated_by=$this->Auth->user('id');
            if ($this->EmployeeSkills->save($employeeSkill)) {
                $applierEmail = $employeeSkill->employee['office_email'];
                $approver=$this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
                $email = new Email();
                $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                    ->setto($applierEmail)
                    ->setemailFormat('html')
                    ->setTemplate('skill_approved')
                    ->setsubject('Skill approved')
                    ->setViewVars([
                        'skillApplier' => $employeeSkill->employee['first_name'],
                        'skill' => $employeeSkill->skill['skill_name'],
                        'level' => $employeeSkill->skill_level['level_name'],
                        'approver' => $approver,
                        ])
                    ->send();

                $this->Flash->success(__('The employee skill has been approved.'));
                //return $this->redirect(["action" => "approval-index"]);
                $this->redirect($this->referer());
            }else{
                $this->Flash->error(__('The employee skill could not be approved. Please, try again.'));
            }
        }
        else{
            $this->Flash->error(__('You dont have access to view this page.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $role = $this->Auth->user('role_id');
        $allowed = array(1,2,3,4,5,6);
        if(in_array($role, $allowed))
        {
            $employeeSkill = $this->EmployeeSkills->newEntity();
            if ($this->request->is('post')) {
                $error=false;
                foreach($this->request->data as $data)
                {
                    foreach($data as $item)
                    {
                        $employeeSkill = $this->EmployeeSkills->newEntity();
                        $empSkills = $this->EmployeeSkills->patchEntity($employeeSkill,$item);
                        $empSkills->status=2;
                        $empSkills->employee_id=$this->Auth->user('id');
                        if(!$this->EmployeeSkills->skillLevelCheck($empSkills->skill_id,$empSkills->skill_level_id,$empSkills->employee_id))
                        {
                            $this->EmployeeSkills->save($empSkills);
                        }else{
                            $error=true;
                        }
                    }
                    if(!$error) {
                        $this->Flash->success(__('The employee skills have been saved.'));
                    }else{
                        $this->Flash->error(__('Some employee skills could not be saved because skill level was already added.Please try again.'));
                    }
                    return $this->redirect(array("action" => "mySkills"));
                }
                $this->Flash->error(__('The employee skills could not be saved. Please, try again.'));
            }
            $employees = $this->EmployeeSkills->Employees->find('list', ['limit' => 200]);

            $skills_cat = $this->EmployeeSkills->Skills->find('all')->contain(['skillCategories'])->group(['Skills.skill_category_id'])->toArray();
            $skill_with_categories=array();
            foreach($skills_cat as $cat){
                $skills = $this->EmployeeSkills->Skills->find('all')->contain(['skillCategories'])->where(['Skills.skill_category_id'=>$cat->skill_category_id])->toArray();

                foreach ($skills as $sk) {
                    $skill_with_categories[$cat->SkillCategories['name']][$sk->id] = $sk->skill_name;
                }
            }

            $this->set(compact('employeeSkill', 'employees'));
            $this->set('skills', $skill_with_categories);
        }
        else{
            $this->Flash->error(__('You dont have access to view this page.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Skill id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function rejectSkill($id = null)
    {
        $role = $this->Auth->user('role_id');
        $allowed = array(1,2);
        if(in_array($role, $allowed))
        {
            $employeeSkill = $this->EmployeeSkills->get($id, [
                'contain' => ['Skills','SkillLevels','Employees']
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                //debug($this->request->getData());
                $employeeSkill = $this->EmployeeSkills->patchEntity($employeeSkill, $this->request->getData());
                $employeeSkill->status = 0;
                $employeeSkill->updated_by=$this->Auth->user('id');
                //debug($employeeSkill);
               
                if ($this->EmployeeSkills->save($employeeSkill)) {
                    $applierEmail = $employeeSkill->employee['office_email'];
                    $approver=$this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
                    $applierEmail=rtrim($applierEmail);
                    $email = new Email();
                    $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                        ->setto([$applierEmail])
                        ->setemailFormat('html')
                        ->setTemplate('skill_rejected')
                        ->setsubject('Skill rejected')
                        ->setViewVars([
                            'skillApplier' => $employeeSkill->employee['first_name'],
                            'skill' => $employeeSkill->skill['skill_name'],
                            'level' => $employeeSkill->skill_level['level_name'],
                            'approver' => $approver,
                            'reason' => $employeeSkill->comments,
                            ])
                        ->send();

                    $this->Flash->success(__('The skill was rejected with comments.'));

                    return $this->redirect(['action' => 'approval_index']);
                }else{
                     $this->Flash->error(__('The skill could not be rejected. Please, try again.')); 
                }
            }
            $this->set(compact('employeeSkill'));
        }
        else{
            $this->Flash->error(__('You dont have access to view this page.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Skill id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $role = $this->Auth->user('role_id');
        $allowed = array(1,2);
        if(in_array($role, $allowed))
        {
            $this->request->allowMethod(['post', 'delete']);
            $employeeSkill = $this->EmployeeSkills->get($id);
            if ($this->EmployeeSkills->delete($employeeSkill)) {
                $this->Flash->success(__('The employee skill has been deleted.'));
            } else {
                $this->Flash->error(__('The employee skill could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'approval_index']);
        }
        else{
            $this->Flash->error(__('You dont have access to view this page.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    public function skillLevelSelect(){
        $this->autorender = false;
        if($this->request->is('Ajax'))
        {
            $skill_id = $this->request->getData('skill');
            //debug($skill_id);exit();
            $skills=$this->skills->get($skill_id);
            $skill_levels_id =explode(",",$skills->skill_level_ids);
            foreach($skill_levels_id as $level_id){
                $level=$this->skillLevels->get($level_id);
                $skill_levels[$level_id]=ucfirst($level->level_name);
            }
            //debug($skill_levels);exit();
        }
        echo json_encode($skill_levels);
        exit();
    }

    public function skillLevelCheck(){
        $this->autorender = false;
        if($this->request->is('Ajax'))
        {
            $skill_id = $this->request->getData('skill_id');
            $skill_level_id = $this->request->getData('skill_level_id');
            $user_id=$this->Auth->user('id');
            if($this->EmployeeSkills->skillLevelCheck($skill_id,$skill_level_id,$user_id))
            {
                echo true;
            }else{
                echo null;
            }
        }
        exit();
    }
    public function skillsGraph($id = null){
        $user_id=$id;
        $label=array();
        $data=array();
        $years=[];
        $default_year = date("Y");
        $date=$this->EmployeeSkills->find('all')->select('from_date')
        ->where(['EmployeeSkills.status'=> '1','EmployeeSkills.employee_id'=> $user_id])
        ->group('YEAR(EmployeeSkills.from_date)')->order(['YEAR(EmployeeSkills.from_date)' => 'DESC'])->toArray();
        foreach($date as $d){
            $y=$d->from_date->format("Y");
            $years[$y]=$y;
        }
        if ($this->request->is('post')) {
            $default_year = $this->request->getData('year');
        }else{
            $default_year = date("Y");
        }
         $skills=$this->EmployeeSkills->find('all',['contain'=>['Skills']])
         ->select(['EmployeeSkills.id','EmployeeSkills.skill_id','Skills.skill_name'])
         ->where(['EmployeeSkills.status'=> '1','YEAR(EmployeeSkills.from_date) ='=>$default_year,'EmployeeSkills.employee_id'=> $user_id])
         ->group('EmployeeSkills.skill_id')
         ->order(['EmployeeSkills.skill_id'=>'Asc'])->toArray();
        foreach($skills as $skill){
            $label[$skill->skill_id] = $skill->skill->skill_name;
            $skill_levels=$this->EmployeeSkills
            ->find('all',['contain'=>['SkillLevels']])
            ->select(['EmployeeSkills.id','EmployeeSkills.skill_id','EmployeeSkills.skill_level_id','EmployeeSkills.from_date'])
            ->where(['EmployeeSkills.status'=> '1','YEAR(EmployeeSkills.from_date) ='=>$default_year,'EmployeeSkills.employee_id'=> $user_id,'EmployeeSkills.skill_id'=>$skill->skill_id])
            ->order(['EmployeeSkills.skill_level_id'=>'Asc'])
            ->toArray();
            //debug($skill_levels);
            $i=0;
            foreach($skill_levels as $sl){

                $data[$skill->skill_id][$i]=array('x'=>$sl->from_date->format('Y-m-d'),'y'=>$sl->skill_level_id);
                $i++;
            }
        }
        $coordinates=json_encode($data,JSON_UNESCAPED_UNICODE);
        $skills=json_encode($label,JSON_UNESCAPED_UNICODE);
        $this->set(compact('label','coordinates','skills','data','years','default_year'));
    }

    public function notifications(){
        if($this->request->is('Ajax'))
        {
            $notify=$this->EmployeeSkills->find('all')->where(['status'=>'2'])->count();
            if($notify){
                echo $notify;
            }else{
                echo 0;
            }
        }
        exit;
    }

    public function test(){
        
    }
}