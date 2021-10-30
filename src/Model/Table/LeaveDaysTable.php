<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeaveDays Model
 *
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\LeaveDay get($primaryKey, $options = [])
 * @method \App\Model\Entity\LeaveDay newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LeaveDay[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeaveDay|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeaveDay|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeaveDay patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LeaveDay[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeaveDay findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeaveDaysTable extends Table
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

        $this->setTable('leave_days');
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
            ->scalar('sick_leave');
//            ->requirePresence('sick_leave', 'create')
//            ->notEmpty('sick_leave');

        $validator
            ->scalar('casual_leave');
//            ->requirePresence('casual_leave', 'create')
//            ->notEmpty('casual_leave');

        $validator
            ->scalar('planned_leave');
//            ->requirePresence('planned_leave', 'create')
//            ->notEmpty('planned_leave');

        $validator
            ->scalar('unplanned_leave');
//            ->requirePresence('unplanned_leave', 'create')
//            ->notEmpty('unplanned_leave');

        $validator
            ->scalar('earned_leave');
//            ->requirePresence('earned_leave', 'create')
//            ->notEmpty('earned_leave');

        $validator
            ->scalar('restricted_leave');
//            ->requirePresence('restricted_leave', 'create')
//            ->notEmpty('restricted_leave');

        $validator
            ->scalar('day_off');
//            ->requirePresence('day_off', 'create')
//            ->notEmpty('day_off');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 100)
            ->notEmpty('created_by');

        $validator
            ->scalar('updated_by')
            ->maxLength('updated_by', 100)
            ->notEmpty('updated_by');

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
