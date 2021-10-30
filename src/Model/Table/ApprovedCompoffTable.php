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

class ApprovedCompoffTable extends Table
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

        $this->setTable('approved_compoff');
        $this->setDisplayField('employee_name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
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
            ->integer('employee_id')
            ->allowEmpty('employee_id', 'create');

        $validator
            ->scalar('employee_name')
            ->maxLength('employee_name', 255)
            ->requirePresence('employee_name', 'create')
            ->notEmpty('employee_name');

        $validator
            ->decimal('approved_hour')
            ->requirePresence('approved_hour', 'create')
            ->notEmpty('approved_hour');

        return $validator;
    }

    
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        return $rules;
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