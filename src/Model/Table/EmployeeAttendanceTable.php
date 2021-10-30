<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeAttendance Model
 *
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\EmployeeAttendance get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeAttendance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeAttendance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeAttendance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeAttendance|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeAttendance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeAttendance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeAttendance findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeeAttendanceTable extends Table
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

        $this->setTable('employee_attendance');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id'
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
            ->scalar('employee_name')
            ->maxLength('employee_name', 50)
            ->allowEmpty('employee_name');

        $validator
            ->scalar('shift')
            ->maxLength('shift', 30)
            ->allowEmpty('shift');

        $validator
            ->time('shift_start_at')
            ->allowEmpty('shift_start_at');

        $validator
            ->time('shift_end_at')
            ->allowEmpty('shift_end_at');

        $validator
            ->date('date')
            ->allowEmpty('date');

        $validator
            ->time('checkin')
            ->allowEmpty('checkin');

        $validator
            ->time('checkout')
            ->allowEmpty('checkout');

        $validator
            ->scalar('hours_worked')
            ->maxLength('hours_worked', 30)
            ->allowEmpty('hours_worked');

        $validator
            ->time('extra_hours')
            ->allowEmpty('extra_hours');

        $validator
            ->time('less_hours')
            ->allowEmpty('less_hours');

        $validator
            ->time('late_by')
            ->allowEmpty('late_by');

        $validator
            ->time('early_by')
            ->allowEmpty('early_by');

        $validator
            ->boolean('is_present')
            ->allowEmpty('is_present');

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
