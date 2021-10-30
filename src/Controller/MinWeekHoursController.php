<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MinWeekHours Controller
 *
 * @property \App\Model\Table\MinWeekHoursTable $MinWeekHours
 *
 * @method \App\Model\Entity\MinWeekHour[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MinWeekHoursController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $minWeekHours = $this->paginate($this->MinWeekHours);

        $this->set(compact('minWeekHours'));
    }

    /**
     * View method
     *
     * @param string|null $id Min Week Hour id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $minWeekHour = $this->MinWeekHours->get($id, [
            'contain' => []
        ]);

        $this->set('minWeekHour', $minWeekHour);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $minWeekHour = $this->MinWeekHours->newEntity();
        if ($this->request->is('post')) {
            $minWeekHour = $this->MinWeekHours->patchEntity($minWeekHour, $this->request->getData());
            if ($this->MinWeekHours->save($minWeekHour)) {
                $this->Flash->success(__('The min week hour has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The min week hour could not be saved. Please, try again.'));
        }
        $this->set(compact('minWeekHour'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Min Week Hour id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $minWeekHour = $this->MinWeekHours->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $minWeekHour = $this->MinWeekHours->patchEntity($minWeekHour, $this->request->getData());
            if ($this->MinWeekHours->save($minWeekHour)) {
                $this->Flash->success(__('The min week hour has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The min week hour could not be saved. Please, try again.'));
        }
        $this->set(compact('minWeekHour'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Min Week Hour id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $minWeekHour = $this->MinWeekHours->get($id);
        if ($this->MinWeekHours->delete($minWeekHour)) {
            $this->Flash->success(__('The min week hour has been deleted.'));
        } else {
            $this->Flash->error(__('The min week hour could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
