<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\EmployeeAttendance;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Mailer\Email;

/**
 * EmployeeAttendance Controller
 *
 * @property \App\Model\Table\EmployeeAttendanceTable $EmployeeAttendance
 *
 * @method \App\Model\Entity\EmployeeAttendance[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeAttendanceController extends AppController
{
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function initialize(){
        
        parent::initialize();

        $this->loadComponent('Auth');
        $this->loadComponent('Flash');
        $this->loadModel("Employees");
        $this->loadModel("MinWeekHours");
    }
    public function index()
    {
        $role_id = $this->Auth->user('role_id');
        $optionAvail = false;        
        $where = array();
        $data=$this->request->getQuery();
        if($this->request->getQuery('from-date') != null && $this->request->getQuery('to-date') != null){
            $where['date <='] = $this->request->getQuery('to-date');
            $where['date >='] = $this->request->getQuery('from-date');
        }
        if($this->request->getQuery('office_location') != null){
            $where['office_location'] = $this->request->getQuery('office_location');
        }
        if($this->request->getQuery('emploees') != null){
            $where['employee_id'] = $this->request->getQuery('emploees');
        }
        if($role_id <= 3){
            $employeeAttendance = $this->EmployeeAttendance->find('all', ['order' => ['EmployeeAttendance.created' => 'desc']])->contain(['Employees'])->where($where);
            $optionAvail = true;
        }
        else{
            $employeeAttendance = $this->EmployeeAttendance->find('all', ['order' => ['created' => 'desc']])->where(['employee_id'=>$this->Auth->user('id')])->where($where);
        }
        $employeeAttendance = $this->paginate($employeeAttendance);
        $employees = $this->Employees->find();
        $this->set(compact('employeeAttendance','optionAvail','employees',"where"));
    }

    public function getUser($office = null){
        $employees = $this->Employees->find()->where(['office_location'=>$office])->order(['first_name'=>'ASC']);
        $options = '<option value="">Select Option</option>';
        foreach ($employees as $key => $value) {
            $options .= '<option value="'.$value->id.'">'.$value->first_name.' '.$value->last_name.'</option>';
        }
        echo $options;
        exit;
    }

    public function weeklyData()
    {
        $role_id = $this->Auth->user('role_id');
        $office_location = $this->Auth->user('office_location');
        $optionAvail = false;
        // to fetch the min weekly office hours
        $minhours = $this->MinWeekHours->find()->where(['office_location'=>$office_location])->first()->hours;
        // end

        // to fetch start of the week
        for($i = 0;$i<32;$i++){
            $date = date('Y-m-d',(strtotime ( '-'.$i.' day' , strtotime (date('Y-m-d')) ) ));
              if(date('w',strtotime($date)) == 0){
                $final_date = $date;
                  break;
              }
            }
        //end
        // to fetch all the days of the week
        $weeklyData = array();
        $week_count =1;
        for($i = 1;$i<32;$i++){
            if($week_count >=5 ){
                break;
            }
            $date = date('Y-m-d',(strtotime ( '-'.$i.' day' , strtotime (date('Y-m-d')) )));
            $weeklyData[$date]['day'] = date('l',strtotime($date));
            $weeklyData[$date]['week'] = $week_count;
            if(date('w',strtotime($date)) == 6){
                $week_count++;
            }
        }
        // end
        if($role_id == 1 || $role_id == 2 || $role_id == 3){
            $employeeAttendance = $this->EmployeeAttendance->find('all', ['order' => ['created' => 'desc']])->where(['date <='=>date('Y-m-d')])->limit(31);
            $optionAvail = true;
        }
        else{
            $employeeAttendance = $this->EmployeeAttendance->find('all', ['order' => ['created' => 'desc']])->where(['employee_id'=>$this->Auth->user('id'),'date <='=>date('Y-m-d')])->limit(31);
        }
        // for computing weekly data
        $total_hours = array();
        foreach ($employeeAttendance as $key => $value) {
            if(isset($weeklyData[date('Y-m-d',strtotime($value->date))])){
                $weeklyData[date('Y-m-d',strtotime($value->date))]['data'] = $value;
                $temp = explode(':', $value->hours_worked);
                $total_hours['hours'] =  (isset($total_hours['hours']) ? $total_hours['hours']:0) + (int)$temp[0];
                $total_hours['minute'] = (isset($total_hours['minute']) ? $total_hours['minute']:0) + (int)$temp[1];
            }
        }
        $week_count =1;
        $weeklyHours = array();
        foreach ($weeklyData as $key => $value) {
            if(isset($value['data'])){
                $temp = explode(':', $value['data']->hours_worked);
                $weeklyHours[$week_count]['hours'] =  (isset($weeklyHours[$week_count]['hours'])? $weeklyHours[$week_count]['hours'] :0) +$temp[0];
                $weeklyHours[$week_count]['minute'] = (isset($weeklyHours[$week_count]['minute'])? $weeklyHours[$week_count]['minute']:0) +$temp[1];
            }
            if(date('w',strtotime($key)) == 6){
                $week_count++;
            }
        }
        //end
        $weeklyTotalHours = array();
        foreach ($weeklyHours as $key => $value) {
            if($value['minute'] >= 60){
            $temp = $value['minute']/60;
            $value['hours'] = $value['hours'] + $temp;
            if($value['hours'] < $minhours)
                $color = 'red';
            elseif($value['hours'] > $minhours)
                $color = 'blue';
            else
                $color = 'green';
            $weeklyTotalHours[$key]['hours'] = str_replace('.', ':', (string)$value['hours']);
            $weeklyTotalHours[$key]['color'] = $color;
            }else{
                $total = $value['hours'].'.'.$value['minute'];
                $ftotal = (float)$total;
                if($ftotal < $minhours)
                    $color = 'red';
                elseif($ftotal > $minhours)
                    $color = 'blue';
                else
                    $color = 'green';

                $weeklyTotalHours[$key]['hours'] = $value['hours'].':'.$value['minute'];
                $weeklyTotalHours[$key]['color'] = $color;
            }
        }

        if(!empty($total_hours)){
            if($total_hours['minute'] >= 60){
                $temp = $total_hours['minute']/60;
                $total_hours['hours'] = $total_hours['hours'] + $temp;
                $total_time = str_replace('.', ':', (string)$total_hours['hours']);
            }else{
                $total_time = $total_hours['hours'].':'.$total_hours['minute'];
            }
         }else {
            $total_time="00:00:00";
         }
        $this->set(compact('employeeAttendance','weeklyData','optionAvail','total_time','weeklyTotalHours'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee Attendance id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userId=$this->Auth->user('id');
        $role=$this->Auth->user('role_id');

        if($role==2){
                $employeeAttendance = $this->EmployeeAttendance->get($id, ['contain' => ['Employees']]);
        }else{
            $employeeAttendance = $this->EmployeeAttendance->find('all')->contain(['Employees'])->where(['Employees.id'=>$userId,"EmployeeAttendance.id"=>$id])->first();  
        }
        $this->set('employeeAttendance', $employeeAttendance);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Employees');
        if ($this->request->is('post')) {
             $data=$this->request->getData();
             if($data['attendenceSheet']['name']!=null) {
                $fileName = $data['attendenceSheet']['name'];
                $uploadPath = '../webroot/attendence_csv/';        
                $folder = new Folder($uploadPath);
                if (is_null($folder->path)) {
                    $folderNew = new Folder();
                    $folderNew->create($uploadPath);  
                }

                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $uploadFile = $uploadPath."attendence_sheet_".date("d-m-y").".".$ext;

                if(move_uploaded_file($data['attendenceSheet']['tmp_name'],$uploadFile)){
                     $attendenceSheet=fopen($uploadFile,'r');
                     if($attendenceSheet) {
                            $index=0;
                            while(($line = fgetcsv($attendenceSheet)) !== FALSE) {

                                $nameArray=  explode(" ",$line[2]);
                                  $first_name=$nameArray[0];
                                 if(count($nameArray)>1) {
                                   $last_name=(count($nameArray)==3) ? $nameArray[2] : $nameArray[1];
                                 }else {
                                    $last_name="";
                                 }
                                 $details=$this->Employees->find('all')->where(['first_name like'=> "%".$first_name."%",'last_name like'=>"%".$last_name."%"])->first();                                 
                                if(!empty($details)) {
                                 $shiftTime=explode("-",$details->shift_type);
                                }
                                if($line[9]=="1st Shift"){
                                    $shiftTime[0]=$shiftTime[0]."am";
                                    $shiftTime[1]=$shiftTime[1]."pm";
                                }else if($line[9]=="2nd Shift"){
                                    if(strtotime($shiftTime[0]) < strtotime("12:00:00"))
                                    {
                                        $shiftTime[0]=$shiftTime[0]."am";
                                    }else{
                                        $shiftTime[0]=$shiftTime[0]."pm";
                                    }
                                    $shiftTime[1]=$shiftTime[1]."pm";
                                }else{
                                    $shiftTime[0]=$shiftTime[0]."pm";
                                    $shiftTime[1]=$shiftTime[1]."am";
                                }

                                // 0 => "16-Jul-20"
                                // 1 => "1"
                                // 2 => "Lidya Fernandes"
                                // 3 => "Goenche Apps and Sites Pvt Ltd"
                                // 4 => "Finance Coordinator"
                                // 5 => "Default"
                                // 6 => ""
                                // 7 => ""
                                // 8 => ""
                                // 9 => "1st Shift"
                                // 10 => "09:15:00"
                                // 11 => "18:15:00"
                                // 12 => "00:00"
                                // 13 => "0"
                                // 14 => "00:00"
                                // 15 => "151"
                                // 16 => "0"
                                // 17 => "Present"
                                // 18 => "09:15:00"
                                // 19 => "18:15:00"

                                $employeeAttendenceData[$index]["employee_id"]     = !empty($details) ? $details->id : NULL;
                                $employeeAttendenceData[$index]["employee_name"]   = $line[2];
                                $employeeAttendenceData[$index]["shift"]           = $line[9];
                                $employeeAttendenceData[$index]["date"]            = date("Y-m-d",strtotime($line[0]));
                                $employeeAttendenceData[$index]["checkin"]         = date("H:i:s",strtotime($line[10]));
                                $employeeAttendenceData[$index]["checkout"]        = date("H:i:s",strtotime($line[11]));
                                $employeeAttendenceData[$index]["is_present"]      = ($line[17] == "Absent") ? 0 : 1 ;
                                $employeeAttendenceData[$index]["shift_start_at"]  = date("h:i:s",strtotime($shiftTime[0]));
                                $employeeAttendenceData[$index]["shift_end_at"]    = date("h:i:s",strtotime($shiftTime[1]));

                                $workingHours=(strtotime($shiftTime[1])-strtotime($shiftTime[0]));                                
                                $workedFor=(strtotime($line[11])-strtotime($line[10]));                                                                

                                $diff = "00:00:00";                                

                                if ($employeeAttendenceData[$index]["is_present"] === 1) {
                                    if (date("H:i:s", $workedFor) < date("H:i:s", $workingHours)) {                                         
                                        $diff = $workingHours - $workedFor;
                                        $employeeAttendenceData[$index]['less_hours'] = date("H:i:s", $diff);
                                    } else {                                        
                                        $diff= ($workedFor)-($workingHours);                                    
                                        if(date("H:i:s", $diff) != "00:00:00"){
                                            $employeeAttendenceData[$index]['extra_hours']=date("H:i:s", $diff);
                                        }
                                    }       
                                }

                                $employeeAttendenceData[$index]['hours_worked']=date("H:i:s",($workedFor));
                                if((strtotime($line[10])-strtotime($shiftTime[0]))>0)
                                {
                                    $employeeAttendenceData[$index]["late_by"]        = !empty($shiftTime) ? date("H:i:s",(strtotime($line[10])-strtotime($shiftTime[0]))) : "00:00:00" ;
                                    $employeeAttendenceData[$index]["early_by"]       = "00:00:00" ;
                                }else {
                                    $employeeAttendenceData[$index]["late_by"]        = "00:00:00" ;
                                    $employeeAttendenceData[$index]["early_by"]       = !empty($shiftTime) ? date("H:i:s",(strtotime($shiftTime[0])-strtotime($line[10]))) : "00:00:00" ;
                                } 
                                $index++;
                            }

                    fclose($attendenceSheet);
                    $employeeAttendence = $this->EmployeeAttendance->newEntities($employeeAttendenceData);                    
                    if ($this->EmployeeAttendance->saveMany($employeeAttendence)) {
                        $this->Flash->success(__('The employee attendance has been saved.'));
                    }else
                        $this->Flash->error(__('The employee attendance could not be saved. Please, try again.'));
                }
            }else{
                $this->Flash->error(__('Unable to upload file, please try again.'));
            }
         }
       }
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Attendance id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeeAttendance = $this->EmployeeAttendance->get($id, [
            'contain' => ['Employees']
        ]);  
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inputData=$this->request->getData();
            $shiftTiming=explode("-",$employeeAttendance['employee']['shift_type']);
            if($employeeAttendance['shift']=="1st Shift"){
                $shiftTiming[0]=$shiftTiming[0]."am";
                $shiftTiming[1]=$shiftTiming[1]."pm";
            }else if($employeeAttendance['shift']=="2nd Shift"){
                if(strtotime($shiftTiming[0]) < strtotime("12:00:00"))
                {
                    $shiftTiming[0]=$shiftTiming[0]."am";
                }else{
                    $shiftTiming[0]=$shiftTiming[0]."pm";
                }
                $shiftTiming[1]=$shiftTiming[1]."pm";
            }else{
                $shiftTiming[0]=$shiftTiming[0]."pm";
                $shiftTiming[1]=$shiftTiming[1]."am";
            }

            $shiftTiming[1]=date("H:i:s",strtotime($shiftTiming[1]));
            $shiftTiming[0]=date("H:i:s",strtotime($shiftTiming[0]));
            $workingHours=(strtotime($shiftTiming[1])-strtotime($shiftTiming[0]));
            $workedFor=(strtotime($inputData['checkout'])-strtotime($inputData['checkin']));
            $diff=($workedFor)-($workingHours);
    
            if($diff>0){
                $inputData['extra_hours']=date("H:i:s",($diff));
            }else{
                $inputData['extra_hours'] ="00:00:00" ;
            }

            $inputData['hours_worked']=date("H:i:s",($workedFor));
            if((strtotime($inputData['checkin'])-strtotime($shiftTiming[0]))>0)
            {
               $inputData['early_by'] = "00:00:00" ;
               $inputData['late_by'] = !empty($shiftTiming) ? date("H:i:s",(strtotime($inputData['checkin'])-strtotime($shiftTiming[0]))) : "00:00:00" ;
            }else{          
               $inputData['early_by'] = !empty($shiftTiming) ? date("H:i:s",(strtotime($shiftTiming[0])-strtotime($inputData['checkin']))) : "00:00:00" ;
               $inputData['late_by'] = "00:00:00" ;
            } 
            $employeeAttendance = $this->EmployeeAttendance->patchEntity($employeeAttendance,$inputData);
            if ($this->EmployeeAttendance->save($employeeAttendance)) {
                $this->Flash->success(__('The employee attendance has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee attendance could not be saved. Please, try again.'));
        }
        //$employees = $this->EmployeeAttendance->Employees->find('list', ['limit' => 200]);
        $employees = $this->EmployeeAttendance->find('list', ['limit' => 200]);
        $this->set(compact('employeeAttendance', 'employees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Attendance id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeAttendance = $this->EmployeeAttendance->get($id);
        if ($this->EmployeeAttendance->delete($employeeAttendance)) {
            $this->Flash->success(__('The employee attendance has been deleted.'));
        } else {
            $this->Flash->error(__('The employee attendance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function testMail(){
        $this->autoRender=false;
         $email=['sankalp.chari@sjinnovation','abhishek.naik@sjinnovation.com','sarwar.masud@sjinnovation.com'];   
         $employeeEmail=$this->Auth->user('office_email');
         $employeeEmail="sankalp.chari@sjinnovation";
          echo "Email sent to:- ".$employeeEmail;
           $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
            ->setto($employeeEmail)
            ->setemailFormat('html')
                ->setTemplate('test')
                ->setsubject('testing leaves')
                ->send();
       }
}


