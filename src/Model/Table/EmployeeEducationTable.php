<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeEducation Model
 *
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\EmployeeEducation get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeEducation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeEducation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeEducation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeEducation|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeEducation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeEducation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeEducation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeeEducationTable extends Table
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

        $this->setTable('employee_education');
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
            ->scalar('educational_institute_name')
            ->maxLength('educational_institute_name', 50)
            ->requirePresence('educational_institute_name', 'create')
            ->notEmpty('educational_institute_name');

        $validator
            ->scalar('duration')
            ->maxLength('duration', 50)
            ->requirePresence('duration', 'create')
            ->notEmpty('duration');

        $validator
            ->date('year_of_completion')
            ->allowEmpty('year_of_completion');

        $validator
            ->scalar('certification')
            ->maxLength('certification', 20)
            ->allowEmpty('certification');

        $validator
            ->scalar('percentage')
            ->maxLength('percentage', 20)
            ->requirePresence('percentage', 'create')
            ->notEmpty('percentage');

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
