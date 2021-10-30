<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Salary Controller
 *
 * @property \App\Model\Table\SalaryTable $Salary
 *
 * @method \App\Model\Entity\Salary[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalaryController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees']
        ];
        $Salary = $this->Salary->find()->WHERE(['is_approved'=>1])->WHERE(['is_updated'=>0]);
        $salary = $this->paginate($Salary);;
        $this->set(compact('salary'));
    }

    /**
     * View method
     *
     * @param string|null $id Salary id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($employeeId = null, $employeeName = null)
    {

        $salaries = $this->Salary->find('all')->contain(['Designations'])->WHERE(['employee_id'=>$employeeId])->WHERE(['is_approved'=>1])->WHERE(['is_updated'=>0]);
        $this->set(compact('salaries','employeeName'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {        
        $salary = $this->Salary->newEntity();
        $designations = $this->Salary->Designations->find('list');
        $designations = $designations->toArray();
        $designations[''] = 'Select Designation';

        if ($this->request->is(['patch', 'post', 'put'])) {
            // dd($this->request->getData());
            $salary = $this->Salary->patchEntity($salary, $this->request->getData());
//            dd($this->request->getData());
            if ($this->Salary->save($salary)) {
                $this->Flash->success(__('The salary has been added. And pending for Approval.'));

                return $this->redirect(['controller'=>'employees','action' => 'index']);
            }
            $this->Flash->error(__('The salary could not be saved. Please, try again.'));
        }

        $employee = $this->Salary->Employees->get($id, [
            'contain' => ['Salary']
        ]);
//        dd($employee->toArray());
        $this->set(compact('salary','employee','designations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Salary id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null,$empId = null)
    {
        $salary = $this->Salary->get($id, ['contain' => ['Employees'] ]);
        $designations = $this->Salary->Designations->find('list');
        $designations = $designations->toArray();
        $designations[''] = 'Select Designation';
        $selectedDesignation=$salary['employees']['designation_id'];
        $employeeName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $SalaryForm = $this->request->getData();
            $SalaryForm['is_approved']= 0;
            $SalaryForm['is_updated'] = 1;
            $SalaryForm['id']=$id;
            $SalaryForm['designation_id'] = $SalaryForm['designation_id']=="" ? 0 :$SalaryForm['designation_id'];

            $salary = $this->Salary->patchEntity($salary, $SalaryForm);
            if ($this->Salary->save($salary)) {
                $this->Flash->success(__('The salary has been saved. Pending for approval'));
                return $this->redirect(['controller'=>'employees','action'=>'index']);
            }
            $this->Flash->error(__('The salary could not be saved. Please, try again.'));
        }
        $employees = $this->Salary->Employees->find('list', ['limit' => 200]);
        $this->set(compact('salary', 'employees','employeeName','designations','selectedDesignation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Salary id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salary = $this->Salary->get($id);
        if ($this->Salary->delete($salary)) {
            $this->Flash->success(__('The salary has been deleted.'));
        } else {
            $this->Flash->error(__('The salary could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function approve($id = null,$employeeId = null){

        $salary = $this->Salary->get($id, [
            'contain' => ['Employees']
        ]);
            // dd($salary);
        $userName = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
        $salary['id'] = $id;
        $salary['is_approved'] = 1;
        $salary['approved_by'] = $userName;
        $salary['is_updated']  = 0;

        // dd($salary);
        if ($this->Salary->save($salary)) {
            $this->Flash->success(__('The Salary request has been Approved.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The Salary request could not be processed. Please, try again.'));
    }


    public function pending(){
        $this->paginate = [
            'contain' => ['Employees']
        ];
        $Salary = $this->Salary->find()->WHERE(['is_approved'=>0])->WHERE(['is_updated'=>1]);
        $salary = $this->paginate($Salary);;
        $this->set(compact('salary'));        
    }
}
