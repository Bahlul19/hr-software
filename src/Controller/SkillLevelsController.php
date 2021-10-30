<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SkillLevels Controller
 *
 * @property \App\Model\Table\SkillLevelsTable $SkillLevels
 *
 * @method \App\Model\Entity\SkillLevel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SkillLevelsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if($this->checkRole()){
            $skillLevels = $this->paginate($this->SkillLevels);
            $this->set(compact('skillLevels'));
        }else{
            return $this->redirect(['controller'=>'Employees','action' => 'dashboard']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Skill Level id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if($this->checkIfRecordExist($id)){
            $this->Flash->error(__('The skill levels your are try to access does not exist.'));
            return $this->redirect(['action' => 'index']);
       }
        if($this->checkRole()){
            $skillLevel = $this->SkillLevels->get($id, [
                'contain' => ['EmployeeSkills']
            ]);
            $this->set('skillLevel', $skillLevel);
        }else{
            return $this->redirect(['controller'=>'Employees','action' => 'dashboard']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $skillLevel = $this->SkillLevels->newEntity();
        if ($this->request->is('post')) {
            $data= $this->request->getData();
            $newData=explode(",",$data['level_name']);
            $newArray;
            foreach($newData as $key => $d){
                $newArray[$key]['level_name']=$d;
            }
            $skillLevelMultiple=$this->SkillLevels->newEntities($newArray);
            $skillLevelMultiple = $this->SkillLevels->patchEntities($skillLevelMultiple,$newArray);
            if ($this->SkillLevels->saveMany($skillLevelMultiple)) {
                $this->Flash->success(__('The skill level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The skill level could not be saved. Please, try again.'));
        }
        $this->set(compact('skillLevel'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Skill Level id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     $skillLevel = $this->SkillLevels->get($id, [
    //         'contain' => []
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $skillLevel = $this->SkillLevels->patchEntity($skillLevel, $this->request->getData());
    //         if ($this->SkillLevels->save($skillLevel)) {
    //             $this->Flash->success(__('The skill level has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The skill level could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('skillLevel'));
    // }

    /**
     * Delete method
     *
     * @param string|null $id Skill Level id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $skillLevel = $this->SkillLevels->get($id);
    //     if ($this->SkillLevels->delete($skillLevel)) {
    //         $this->Flash->success(__('The skill level has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The skill level could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}


