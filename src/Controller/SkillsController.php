<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Skills Controller
 *
 * @property \App\Model\Table\SkillsTable $Skills
 *
 * @method \App\Model\Entity\Skill[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SkillsController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->loadModel('SkillLevels');
        $this->loadModel('SkillCategories');

        $skillLevels=$this->SkillLevels->find("all")->select(['id','level_name'])->toArray();
        foreach($skillLevels as $level){
                $levels[$level['id']]=ucfirst($level['level_name']);
        }

        $skillCategories=$this->SkillCategories->find("all")->select(['id','name'])->toArray();
        foreach($skillCategories as $cat){
                $categories[$cat['id']]=$cat['name'];
        }

        $this->levels=$levels;
        $this->categories=$categories;
    }

    
     /* View method
     *
     * @param string|null $id Skill id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {     
        if(!$this->checkRole()){
            return $this->redirect(['controller'=>'Employees','action' => 'dashboard']); 
        }
        if($this->checkIfRecordExist($id)){
            $this->Flash->error(__('The skill your are try to access does not exist.'));
            return $this->redirect(['action' => 'index']);
       }
        $skill = $this->Skills->get($id, [
            'contain' => ['EmployeeSkills','SkillCategories']
        ]);
        $levels=$this->levels;
        $categories=$this->categories;
        $this->set(compact('skill','levels','categories'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    { 
         if(!$this->checkRole()){
            return $this->redirect(['controller'=>'Employees','action' => 'dashboard']); 
        }
        $skill = $this->Skills->newEntity();
        if ($this->request->is('post')) {
            $data=$this->request->getData();
            $data['skill_level_ids']=implode(",",$data['skill_level_ids']);
            // $value=$this->Skills->uploadImage($data['image'],$data['skill_name'],$data['version']);
            // switch($value){
            //     case 1 : 
            //             $data['image']=null;
            //             break;
            //     case 2 :
            //              $this->Flash->error("Some error occure when trying to save the image. Please try again");
            //             break;
            //     case 3 :
            //              $this->Flash->error("The file type is not supported. Please only upload jpg,png images");
            //            break;
            //     default :
            //             $data['image']="..\\".$value;
            // }
            // if($value!=1 || $value!=2){
                $skill = $this->Skills->patchEntity($skill,$data);
                if ($this->Skills->save($skill)) {
                    $this->Flash->success(__('The skill has been saved.'));

                    return $this->redirect($this->referer());
                }
                $this->Flash->error(__('The skill could not be saved. Please, try again.'));
            // }
        }
        $levels=$this->levels;
        $categories=$this->categories;
        $this->set(compact('skill','levels','categories'));

        //all skills list
        $skills_cat = $this->Skills->find('all')->contain(['skillCategories'])->group(['Skills.skill_category_id'])->toArray();
            $skill_with_categories=array();
            foreach($skills_cat as $cat){
                $allSkills = $this->Skills->find('all')->contain(['skillCategories'])->where(['Skills.skill_category_id'=>$cat->skill_category_id])->toArray();

                foreach ($allSkills as $sk) {
                    $skill_with_categories[$cat->SkillCategories['name']][$sk->id] = $sk->skill_name;
                }
            }
        $this->set('allSkills', $skill_with_categories);
    }

    /**
     * Edit method
     *
     * @param string|null $id Skill id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {  
        if(!$this->checkRole()){
            return $this->redirect(['controller'=>'Employees','action' => 'dashboard']); 
        }
        if($this->checkIfRecordExist($id)){
            $this->Flash->error(__('The skill your are try to access does not exist.'));
            return $this->redirect(['action' => 'index']);
       }
        $skill = $this->Skills->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data=$this->request->getData();
            $data['skill_level_ids']=implode(",",$data['skill_level_ids']);
            // if($data['image']['tmp_name']==""){
            //     $data['image']=str_replace("\\","/",$data['imagepath']);
            //     $value=0;
            // }else{
                // $value=$this->Skills->uploadImage($data['image'],$data['skill_name'],$data['version']);
                // switch($value){
                //     case 1 :
                //             $data['image']=null;
                //             break;
                //     case 2 :
                //              $this->Flash->error("Some error occure when trying to save the image. Please try again");
                //             break;
                //     case 3 :
                //              $this->Flash->error("The file type is not supported. Please only upload jpg,png images");
                //            break;
                //     default :
                //             $data['image']="..\\".$value;
                // }
            // }
                // if($value!=1 || $value!=2){
                $skill = $this->Skills->patchEntity($skill,$data);
                if ($this->Skills->save($skill)) {
                    $this->Flash->success(__('The skill has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The skill could not be saved. Please, try again.'));
            // }
        }
        $levels=$this->levels;
        $categories=$this->categories;
        $this->set(compact('skill','levels','categories'));
    }

    public function index()
    {
        $selectedSkill='';
        $selectedLevels="";
        $where=array();
        if($this->request->getQuery('selected_skill')){
             $where['skill_name like']="%".$this->request->getQuery('selected_skill')."%";
             $selectedSkill=$this->request->getQuery('selected_skill');
        }
        if($this->request->getQuery('levels')){
            $where['skill_level_ids like']="%".$this->request->getQuery('levels')."%";
            $selectedLevels=$this->request->getQuery('levels');
        }
        $skills = $this->paginate($this->Skills->find("all")->contain(['SkillCategories'])->where($where)->order(['skill_name']));
        $levels=$this->levels;
        $this->set(compact('skills','levels','selectedLevels','selectedSkill'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Skill id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    { 
         if(!$this->checkRole()){
            return $this->redirect(['controller'=>'Employees','action' => 'dashboard']); 
        }
        if($this->checkIfRecordExist($id)){
            $this->Flash->error(__('The skill your are try to access does not exist.'));
            return $this->redirect(['action' => 'index']);
       }
        $this->request->allowMethod(['post', 'delete']);
        $skill = $this->Skills->get($id);
        if ($this->Skills->delete($skill)) {
            $this->Flash->success(__('The skill has been deleted.'));
        } else {
            $this->Flash->error(__('The skill could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    protected function checkIfRecordExist($id){
        $result=$this->Skills->find('all')->where(['id'=>$id])->toArray();
       return empty($result);
    }
   
    protected function checkRole(){
        $role=$this->Auth->user("role_id");
        if($role<4){
            return true;
        }
        return false;
    }

  public function checkLevels($name=null){
    $name=strtolower($name); 
    $result=$this->Skills->find('all')->select(['skill_name'=>'DISTINCT skill_name'])->where(['LOWER(skill_name) '=>$name])->toArray();
    $string=[];
    foreach($result as $re){
      $string[]=$re['skill_name'];
    } 
    $finalResponse['code']=empty($string) ? 0:1;
    $finalResponse['data']=implode(",",$string);
   
    return $this->response->withType("application/json")->withStringBody(json_encode($finalResponse));
  }

}
