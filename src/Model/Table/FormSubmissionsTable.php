<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormSubmissions Model
 *
 * @property \App\Model\Table\FormsTable|\Cake\ORM\Association\BelongsTo $Forms
 * @property |\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\FormSubmission get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormSubmission newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormSubmission[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormSubmission|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormSubmission|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormSubmission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormSubmission[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormSubmission findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FormSubmissionsTable extends Table
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

        $this->setTable('form_submissions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Forms', [
            'foreignKey' => 'form_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('EmployeesA', [
            'foreignKey' => 'employee_id',
            //'propertyName' => 'employee_id',
            'className'=>'Employees'
   
        ]);
        $this->belongsTo('EmployeesB', [
            'foreignKey' => 'feedback_for',
            //'propertyName' => 'feedback_for',
            'className'=>'Employees'
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
            ->scalar('submitted_data')
            ->requirePresence('submitted_data', 'create')
            ->notEmpty('submitted_data');

        $validator
            ->integer('feedback_for')
            ->allowEmpty('feedback_for');

        $validator
            ->requirePresence('is_visible', 'create')
            ->notEmpty('is_visible');

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
        $rules->add($rules->existsIn(['form_id'], 'Forms'));
        $rules->add($rules->existsIn(['employee_id'],'EmployeesA'));
        $rules->add($rules->existsIn(['feedback_for'],'EmployeesB'));
        return $rules;
    }
}
