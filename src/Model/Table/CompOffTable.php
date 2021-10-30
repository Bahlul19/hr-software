<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\I18n\Time;

/**
 * CompOff Model
 *
 * @method \App\Model\Entity\CompOff get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompOff newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CompOff[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompOff|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompOff|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompOff patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompOff[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompOff findOrCreate($search, callable $callback = null, $options = [])
 */
class CompOffTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('comp_off');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->decimal('number_of_hours')
            ->requirePresence('number_of_hours', 'create')
            ->notEmpty('number_of_hours');

        $validator
            ->scalar('pm_name')
            ->maxLength('pm_name', 255)
            ->requirePresence('pm_name', 'create')
            ->notEmpty('pm_name');

        $validator
            ->scalar('team_name')
            ->maxLength('team_name', 255)
            ->requirePresence('team_name', 'create')
            ->notEmpty('team_name');

        $validator
            ->scalar('project_task_details')
            ->requirePresence('project_task_details', 'create')
            ->notEmpty('project_task_details');

        $validator
            ->scalar('name_of_the_project')
            ->maxLength('name_of_project', 255)
            ->requirePresence('name_of_the_project', 'create')
            ->notEmpty('name_of_the_project');

        return $validator;
    }

    //for getting reporting manager email.
    public function reportingManagerEmail($id = null)
    {
        $employees = TableRegistry::get('Employees');
        $reportingManagerEmail = $employees->find('all')->select('office_email')->WHERE(['id'=>$id])->toArray();

        $email = array();
        foreach ($reportingManagerEmail as $rme){
            $email = $rme['office_email'];
        }

        return $email;
    }

    //for getting reporting manager email.
    public function employeeOfficeEmail($id = null)
    {
        $employees = TableRegistry::get('Employees');
        $reportingManagerEmail = $employees->find('all')->select('office_email')->WHERE(['id'=>$id])->toArray();

        $email = array();
        foreach ($reportingManagerEmail as $rme){
            $email = $rme['office_email'];
        }

        return $email;
    }

    public function employeeNameFromId($id = null) {
        $employees = TableRegistry::get('Employees');
        $employee = $employees->find('all')->WHERE(['id'=>$id])->toArray();

        $name = array();
        foreach ($employee as $e){
            $name = $e['first_name']." ".$e['last_name'];
        }

        return $name;
    }
}
