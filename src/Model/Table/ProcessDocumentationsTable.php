<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProcessDocumentations Model
 *
 * @method \App\Model\Entity\ProcessDocumentation get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProcessDocumentation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProcessDocumentation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProcessDocumentation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProcessDocumentation|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProcessDocumentation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProcessDocumentation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProcessDocumentation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProcessDocumentationsTable extends Table
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

        $this->setTable('process_documentations');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Employees', [
            'foreignKey' => 'last_updated_by',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('AssignProcesses', [
            'foreignKey' => 'process_id',
            'joinType' => 'LEFT'
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
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->scalar('office')
            ->maxLength('office', 100)
            ->requirePresence('office', 'create')
            ->notEmpty('office');

        $validator
            ->scalar('roles')
            ->maxLength('roles', 100)
            ->requirePresence('roles', 'create')
            ->notEmpty('roles');

        $validator
            ->scalar('employee_list')
            ->maxLength('employee_list', 100)
            ->allowEmpty('employee_list');

        $validator
            ->integer('last_updated_by')
            ->allowEmpty('last_updated_by');

        $validator
            ->scalar('tags')
            ->maxLength('tags', 50)
            ->allowEmpty('tags');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['process_id'], 'AssignProcesses'));
        return $rules;
    }

}
