<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Announcements Controller
 *
 * @property \App\Model\Table\AnnouncementsTable $Announcements
 *
 * @method \App\Model\Entity\Announcement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnnouncementsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $role = $this->Auth->user('role_id');
        $userOffice = $this->Auth->user('office_location');
        $allOffice = "All-Offices";
        $keyword="";
        $this->paginate = [
            'limit' =>15
        ];

        if($role == 1 || $role == 2) {
            if (!empty($this->request->getQuery('search'))) {
                $keyword = $this->request->getQuery('search');
                $announcements = $this->Announcements->announcementsSearchResults($keyword);
                $announcements = $this->paginate($announcements);
            } else {
                $announcements = $this->paginate($this->Announcements);
            }
        } else {
            $announcement = $this->Announcements->find()->WHERE(['OR'=>[['offices'=>$userOffice],['offices'=>$allOffice]]]);
            $announcements = $this->paginate($announcement);
        }

        $this->set(compact('announcements', 'keyword'));
    }

    /**
     * View method
     *
     * @param string|null $id Announcement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $announcement = $this->Announcements->get($id, [
            'contain' => []
        ]);

        $this->set('announcement', $announcement);
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
            $announcement = $this->Announcements->newEntity();
            if ($this->request->is('post')) {
                $announcementFormData = $this->request->getData();
                $announcementFormData['start_date'] = date('Y-m-d', strtotime($this->request->getData('start_date')));
                $announcementFormData['end_date'] = date('Y-m-d', strtotime($this->request->getData('end_date')));
                $announcement = $this->Announcements->patchEntity($announcement, $announcementFormData);
                if ($this->Announcements->save($announcement)) {
                    $this->Flash->success(__('The announcement has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The announcement could not be saved. Please, try again.'));
            }
            $this->set(compact('announcement'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Announcement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,3);
        if (in_array($loggedUser, $role)) {
            $announcement = $this->Announcements->get($id, [
                'contain' => []
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $announcementFormData = $this->request->getData();
                $announcementFormData['start_date'] = date('Y-m-d', strtotime($this->request->getData('start_date')));
                $announcementFormData['end_date'] = date('Y-m-d', strtotime($this->request->getData('end_date')));
                $announcement = $this->Announcements->patchEntity($announcement, $announcementFormData);
                if ($this->Announcements->save($announcement)) {
                    $this->Flash->success(__('The announcement has been Updated.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The announcement could not be saved. Please, try again.'));
            }
            $this->set(compact('announcement'));
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Announcement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $loggedUser = $this->Auth->user('role_id');
        $role = array(1,2,3);
        if (in_array($loggedUser, $role)) {
            $this->request->allowMethod(['post', 'delete']);
            $announcement = $this->Announcements->get($id);
            if ($this->Announcements->delete($announcement)) {
                $this->Flash->success(__('The announcement has been deleted.'));
            } else {
                $this->Flash->error(__('The announcement could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        }
        else{
            $this->Flash->error(__('Your session has timed out.'));
            return $this->redirect(array("controller" => "Employees", "action" => "dashboard"));
        }
    }

        /**
     * This method is used to return the record of Patient Notes
     * which is to be edited and return data to populate the facility contact pop up form
     * params:id of current note id
     * returns: data of current id
     */
    public function populateAnnouncement()
    {
        if ($this->request->is(['post'])) {
            $id = $this->request->getData('id');
        }
        $announcement = $this->Announcements->get($id,[
            'fields' => ['announcement']
        ]);
        $announcement =  json_encode($announcement->toArray());
        $this->set([
            'response' => $announcement ,
            '_serialize' => 'response',
        ]);
        $this->RequestHandler->renderAs($this, 'json');
    }
}
