<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeExperience Model
 *
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\EmployeeExperience get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeExperience newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeExperience[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeExperience|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeExperience|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeExperience patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeExperience[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeExperience findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeeExperienceTable extends Table
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

        $this->setTable('employee_experience');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->scalar('previous_company')
            ->maxLength('previous_company', 50)
            ->requirePresence('previous_company', 'create')
            ->notEmpty('previous_company');

        $validator
            ->scalar('duration')
            ->maxLength('duration', 50)
            ->requirePresence('duration', 'create')
            ->notEmpty('duration');

        $validator
            ->date('date_of_service_from')
            ->allowEmpty('date_of_service_from');

        $validator
            ->date('date_of_service_to')
            ->allowEmpty('date_of_service_to');

        $validator
            ->integer('last_earned_salary')
            ->allowEmpty('last_earned_salary');

        $validator
            ->scalar('designation')
            ->maxLength('designation', 20)
            ->allowEmpty('designation');

        $validator
            ->scalar('reported_to')
            ->maxLength('reported_to', 20)
            ->requirePresence('reported_to', 'create')
            ->notEmpty('reported_to');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));

        return $rules;
    }
}
