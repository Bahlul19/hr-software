<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Forms Model
 *
 * @property \App\Model\Table\FormFeedbackForTable|\Cake\ORM\Association\HasMany $FormFeedbackFor
 * @property \App\Model\Table\FormFieldsTable|\Cake\ORM\Association\HasMany $FormFields
 * @property \App\Model\Table\FormSubmissionsTable|\Cake\ORM\Association\HasMany $FormSubmissions
 * @property \App\Model\Table\FormVisibilityTable|\Cake\ORM\Association\HasMany $FormVisibility
 *
 * @method \App\Model\Entity\Form get($primaryKey, $options = [])
 * @method \App\Model\Entity\Form newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Form[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Form|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Form|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Form patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Form[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Form findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FormsTable extends Table
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

        $this->setTable('forms');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('FormFeedbackFor', [
            'foreignKey' => 'form_id',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('FormFields', [
            'foreignKey' => 'form_id'
        ]);
        $this->hasMany('FormSubmissions', [
            'foreignKey' => 'form_id'
        ]);
        $this->hasMany('FormVisibility', [
            'foreignKey' => 'form_id',
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
            ->scalar('title')
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 100)
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->date('available_from')
            ->allowEmpty('available_from');

        $validator  
            ->date('available_to')
            ->allowEmpty('available_to');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        return $validator;
    }

    public function buildRules(RulesChecker $rules){
            $rules->add($rules->existsIn(['form_id'], 'FormFeedbackFor'));
            $rules->add($rules->existsIn(['form_id'], 'FormFields'));
            $rules->add($rules->existsIn(['form_id'], 'FormVisibility'));
            return $rules;
    }
}




