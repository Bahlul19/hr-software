<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
// use Cake\Datasource\ConnectionManager;
/**
 * HubstaffHours Controller
 *
 * @property \App\Model\Table\HubstaffHoursTable $HubstaffHours
 *
 * @method \App\Model\Entity\HubstaffHour[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */


class HubstaffHoursController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function initialize(){
        parent::initialize();
        $this->loadModel("Employees");
    }

    public function index()
    {
        $id=$this->Auth->user('id');
        $roleid=$this->Auth->user('role_id');
        $hubstaffname=$this->Auth->user("hubstaff_name");
        $dateSearch=[];
        $empLoc=[];
        $office_location="";
        $employeeHubsatffName="";
        $fromDate="";
        $toDate="";
        $this->paginate = [
            'contain' => []
        ];

        if($this->request->getQuery("office_location")){
            $office_location=$this->request->getQuery("office_location");
            $empLoc['employees.office_location']=$office_location;
        }
  
        if($this->request->getQuery("emploees")){
            $employeeHubsatffName=$this->request->getQuery("emploees");
            $dateSearch['member']=$employeeHubsatffName;
        }

         if($this->request->getQuery("from-date") && $this->request->getQuery("to-date")){
             $fromDate=$this->request->getQuery("from-date");
             $toDate=$this->request->getQuery("to-date");
             $dateSearch['date >=']=$fromDate;
             $dateSearch['date <=']=$toDate;
         }

        $hubstaffName['member']=$hubstaffname;  
        if($roleid<4){
            $query=$this->HubstaffHours->find('all')
                                       ->select(['timeSum'=>'SEC_TO_TIME(sum(TIME_TO_SEC(time)))','concat_activity'=>'GROUP_CONCAT(activity)'])
                                       ->select($this->HubstaffHours)
                                       ->join(['table' => 'employees','type' => 'left','conditions' => 'employees.hubstaff_name = HubstaffHours.member',$empLoc])
                                       ->find('all')
                                       ->where($dateSearch)
                                       ->group(['member','time_zone','date','time','activity']);
            
        }else{
            if(!empty($this->Auth->user('hubstaff_name'))){
                $hubstaffName['member']=$this->Auth->user('hubstaff_name');
                }else{
                    $hubstaffName['member']=$this->Auth->user('first_name')." ".$this->Auth->user('last_name');
                }
            $query=$this->HubstaffHours->find('all')
                                       ->select(['timeSum'=>'SEC_TO_TIME(sum(TIME_TO_SEC(time)))','concat_activity'=>'GROUP_CONCAT(activity)'])
                                       ->select($this->HubstaffHours)
                                       ->where($hubstaffName)
                                       ->where($dateSearch)
                                       ->group(['member','time_zone','date','time','activity']);

        }
        $HubstaffHours = $this->paginate($query);
        $this->set(compact('HubstaffHours','roleid','office_location','employeeHubsatffName','fromDate','toDate'));
    }

    /**
     * View method
     *
     * @param string|null $id Hubstuff Hour id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($date = null,$hubstaffName=null)
    {
        $result=$this->HubstaffHours->find('all')->where(['date'=>$date,'member'=>$hubstaffName])->group(['time_zone','date','activity'])->toArray();
        if(!empty($result)){
            $HubstaffHours=$result;
            $this->set(compact('HubstaffHours','hubstaffName','date'));
        }else{
            $this->Flash->error("The Record does not exist");
            return $this->redirect(['action' => 'index']);  
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if($this->_checkAccess()){
            $roleid=$this->Auth->user('role_id');
            $HubstaffHours = $this->HubstaffHours->newEntity();   
            if ($this->request->is('post')) {
                $hubstaff =$this->request->getData('hubstaffHour');
                if($hubstaff['name']!=null) {
                    $fileName = $hubstaff['name'];
                    $uploadPath = '../webroot/hubstaff_csv/';        
                    $folder = new Folder($uploadPath);
                    if (is_null($folder->path)) {
                        $folderNew = new Folder();
                        $folderNew->create($uploadPath);
                        
                    }
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                    $ext=strtolower($ext);
                    $uploadFile = $uploadPath."attendence_sheet_".date("d-m-y").".".$ext;
                    if($ext=='csv'){
                        if(move_uploaded_file($hubstaff['tmp_name'],$uploadFile)){
                            $hubstaffCsv=fopen($uploadFile,'r');
                            if($hubstaffCsv) { 
                                $index=0;
                                $lineNO=0;
                                $hubstaffHourData;
                                while(($line = fgetcsv($hubstaffCsv)) !== FALSE) { 
                                    if($lineNO>0){
                                        if(count($line)==7){
                                                    $hubstaffHourData[$index]=[
                                                        'organization'=>$line[0],
                                                        'time_zone'=>$line[1],
                                                        'date'=>$line[3],
                                                        'project'=>$line[4],
                                                        'member'=>$line[2],
                                                        'task_id'=>"",
                                                        'task'=>$line[4],
                                                        'time'=>date("H:i:s",strtotime($line[5])),
                                                        'activity'=>$line[6],
                                                        'spent'=>"",
                                                        'currency'=>"",
                                                        'notes'=>"" 
                                                     ]; 

                                        }else{
                                            $hubstaffHourData[$index]=[
                                                    'organization'=>$line[0],
                                                    'time_zone'=>$line[1],
                                                    'date'=>$line[2],
                                                    'project'=>$line[3],
                                                    'member'=>$line[4],
                                                    'task_id'=>$line[5],
                                                    'task'=>$line[6],
                                                    'time'=>date("H:i:s",strtotime($line[7])),
                                                    'activity'=>$line[8],
                                                    'spent'=>$line[9],
                                                    'currency'=>$line[10],
                                                    'notes'=>$line[11] 
                                                 ]; 
                                        }
                                        $index++; 
                                    } 
                                    $lineNO++;
                                }  
                                fclose($hubstaffCsv); 
                                $hubstaffHourAll = $this->HubstaffHours->newEntities($hubstaffHourData);
                                if($this->HubstaffHours->saveMany($hubstaffHourAll)) {  
                                    $this->Flash->success(__('The Hubstaff hour has been saved.'));
                                    return $this->redirect(['action' => 'index']);
                                } else{
                                    $this->Flash->error(__('The Hubstaff hour could not be saved. Please, try again.'));
                                }   
                            }
                        }
                    }
                }
            }
            $this->set(compact('HubstaffHours'));
        }else{
            return $this->redirect(['action' => 'index']); 
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Hubstuff Hour id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if($this->_checkAccess()){
            $result=$this->_recordExist($this->HubstaffHours,$id);
            if($result){ 
                $hubstaffHour = $this->HubstaffHours->get($id, ['contain' => []]);
                    if ($this->request->is(['patch', 'post', 'put'])) {
                        $hubstaffHour = $this->HubstaffHours->patchEntity($hubstaffHour, $this->request->getData());
                        if ($this->HubstaffHours->save($hubstaffHour)) {
                            $this->Flash->success(__('The Hubstuff hour has been saved.'));
                        }
                        $this->Flash->error(__('The Hubstuff hour could not be saved. Please, try again.'));
                    }
                $this->set(compact('hubstaffHour'));
            }else{
                return $this->redirect(['action' => 'index']); 
            }
        }else{
             return $this->redirect(['action' => 'index']);
        } 
    }

    /**
     * Delete method
     *
     * @param string|null $id Hubstuff Hour id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if($this->_checkAccess()){
            if($this->_recordExist($this->HubstaffHours,$id)){
                $this->request->allowMethod(['post', 'delete']);
                $hubstaffHour = $this->HubstaffHours->get($id);
                if ($this->HubstaffHours->delete($hubstaffHour)) {
                    $this->Flash->success(__('The Hubstuff hour has been deleted.'));
                } else {
                    $this->Flash->error(__('The Hubstuff hour could not be deleted. Please, try again.'));
                }
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    public function hubstaffNames(){
           $roleid=$this->Auth->user('role_id');
           $where=[];
           if(!empty($this->request->getQuery())){
               $data=$this->request->getQuery();
               if(!empty($data['office_location']) && !empty($data['emploees'])){
                  $where['id']=$data['emploees'];
               }   
            }
           $employees=$this->paginate($this->Employees->find("all")->where($where));
           $this->set(compact('employees','roleid'));
    }

    public function editHubstaffName($id=null){
        if($this->_checkAccess()){
            if($this->_recordExist($this->Employees,$id)){
                $employees=$this->Employees->get($id);
                    if($this->request->is(['post'])){
                        $data['hubstaff_name']=$this->request->data('hubstaff_name');
                        $employees=$this->Employees->patchEntity($employees,$data); 
                        if($this->Employees->save($employees)){
                        $this->Flash->success("The Hubstaff name has been saved");   
                        }else{
                            $this->Flash->success("The Hubstaff name could not been saved");   
                        }
                    $this->redirect(['action'=>'hubstaff-names']);
                    }
                    $this->set(compact('employees'));
                }else{
                    $this->redirect(['action'=>'hubstaff-names']);
                }
        }else{
            $this->redirect(['action'=>'hubstaff-names']);
        }    
    }

   public function deleteHubstaffName($id=null){
       if($this->_checkAccess()){
            if($this->_recordExist($this->Employees,$id)){
                    $employees=$this->Employees->get($id);
                    $data['hubstaff_name']=null;
                    $employees=$this->Employees->patchEntity($employees,$data);
                    if($this->Employees->save($employees)){
                        $this->Flash->success('Hubstaff Name has been deleted');
                    }else {
                        $this->Flash->error('Some error occure. no changes were made');
                    }
                    $this->redirect(['action'=>'hubstaff-names']);
            }else{
                $this->redirect(['action'=>'hubstaff-names']);  
            }   
       }else{
            $this->redirect(['action'=>'hubstaff-names']);
       }
       
   }

    private function _checkAccess(){
        $roleid=$this->Auth->user('role_id');
      if($roleid<4){
          return true;
      }else {
          return false;
      }
     }
  
     private function _recordExist($tableName,$id){
          $HubstaffHours = $tableName->find('all')->where(['id'=>$id])->toArray();
          if(empty($HubstaffHours)){
              return false;
          }else{
              return true;
          }
     }

    
     public function getEmployeesByHubstaffName(){
         $this->autoRender=false;
         $data=$this->request->data('office');
         $employees=$this->Employees->find('all')->where(['office_location'=>$data])->order(['first_name']);
         $list="<option value='0'>Select Employee</option>";
         foreach($employees as $employee){
           $list.="<option>".$employee->first_name." ".$employee->last_name."</option>";
         }
        return $this->response->withType('application/json')->withStringBody(json_encode(['code' => '1','data'=>($list)]));
     }

     public function getEmployees(){
        $this->autoRender=false;
        $data=$this->request->data('office');
        $employees=$this->Employees->find('all')->where(['office_location'=>$data])->order(['first_name'=>"ASC"]);
        
        $list="<option value='0'>Select Employee</option>";
        foreach($employees as $employee){
          $list.="<option value='".$employee['id']."'>".$employee->first_name." ".$employee->last_name."</option>";
        }
       return $this->response->withType('application/json')->withStringBody(json_encode(['code' => '1','data'=>($list)]));
    }
}


 
