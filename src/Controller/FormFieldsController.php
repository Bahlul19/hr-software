<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FormFields Controller
 *
 * @property \App\Model\Table\FormFieldsTable $FormFields
 *
 * @method \App\Model\Entity\FormField[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FormFieldsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('FormFields');
        $this->loadModel('Roles');
        $this->loadModel('Employees');
        if($this->Auth->user('role_id')==4){
            $this->redirect(['controller'=>'employees',"action"=>'dashboard']);
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Forms']
        ];
        $formFields = $this->paginate($this->FormFields);

        $this->set(compact('formFields'));
    }

    /**
     * View method
     *
     * @param string|null $id Form Field id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $formField = $this->FormFields->get($id, [
            'contain' => ['Forms']
        ]);

        $this->set('formField', $formField);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $formField = $this->FormFields->newEntity();
        if ($this->request->is('post')) {
            $formField = $this->FormFields->patchEntity($formField, $this->request->getData());
            if ($this->FormFields->save($formField)) {
                $this->Flash->success(__('The form field has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The form field could not be saved. Please, try again.'));
        }
        $forms = $this->FormFields->Forms->find('list', ['limit' => 200]);
        $this->set(compact('formField', 'forms'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Form Field id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!empty($this->FormFields->find('all')->where(['id'=>$id])->toArray())){
            $formField = $this->FormFields->get($id, ['contain' => ['Forms']]);
                if ($this->request->is('ajax')) {
                    if ($this->request->is(['patch', 'post', 'put'])) {
                        $this->response->disableCache();
                        $ajaxData = $this->request->getData();
                        $ajaxData['formField']['field_data'] = $ajaxData['field_data'];

                        $formField = $this->FormFields->patchEntity($formField, $this->request->getData());
                        if ($this->FormFields->save($formField)) {
                            $message = "success";
                        } else {
                            $message = "Error";
                        }
                        $this->response->body($message);
                        return $this->response;
                    }
                }
                $forms = $this->FormFields->Forms->find('list', ['limit' => 200]);
                $this->set(compact('formField', 'forms'));
        }else{
            $message = "Error";
            $this->response->body($message);
            return $this->response; 
        }
    }

    /**
     * Form Field View/Edit method
     *
     * @param string|null $id Form Field id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editField($id = null)
    {
        $formField = $this->FormFields->find('all', array('conditions'=>array('form_id'=>$id)));
        if(!empty($formField->toArray())){
            if ($this->request->is(['patch', 'post', 'put'])) {
                $formField = $this->FormFields->patchEntity($formField, $this->request->getData());
                if ($this->FormFields->save($formField)) {
                    $this->Flash->success(__('The form field has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The form field could not be saved. Please, try again.'));
            }
            $forms = $this->FormFields->Forms->find('list', ['limit' => 200]);
            $this->set(compact('formField', 'forms'));   
        }else{
           // $this->Flash->errror("The record you are trying to access is not available/deleted");
            return $this->redirect(['controller'=>'Forms','action' => 'index']);
        } 
    }

    /**
     * Delete method
     *
     * @param string|null $id Form Field id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $formField = $this->FormFields->get($id);
        if ($this->FormFields->delete($formField)) {
            $this->Flash->success(__('The form field has been deleted.'));
        } else {
            $this->Flash->error(__('The form field could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
