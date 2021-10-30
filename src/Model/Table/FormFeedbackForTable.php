<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormFeedbackFor Model
 *
 * @property \App\Model\Table\FormsTable|\Cake\ORM\Association\BelongsTo $Forms
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\FormFeedbackFor get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormFeedbackFor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormFeedbackFor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormFeedbackFor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormFeedbackFor|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormFeedbackFor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormFeedbackFor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormFeedbackFor findOrCreate($search, callable $callback = null, $options = [])
 */
class FormFeedbackForTable extends Table
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

        $this->setTable('form_feedback_for');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Forms', [
            'foreignKey' => 'form_id',
            'joinType'=>'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
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
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        return $rules;
    }
}
