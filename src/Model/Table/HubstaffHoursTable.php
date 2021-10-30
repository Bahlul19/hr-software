<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HubstaffHours Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Tasks
 *
 * @method \App\Model\Entity\HubstaffHour get($primaryKey, $options = [])
 * @method \App\Model\Entity\HubstaffHour newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HubstaffHour[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HubstaffHour|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HubstaffHour|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HubstaffHour patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HubstaffHour[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HubstaffHour findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HubstaffHoursTable extends Table
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

        $this->setTable('hubstaff_hours');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // $this->belongsTo('Employees', [
        //     'foreignKey' => 'member'
        // ]);
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
            ->scalar('organization')
            ->maxLength('organization', 20)
            ->allowEmpty('organization');

        $validator
            ->scalar('time_zone')
            ->maxLength('time_zone', 50)
            ->allowEmpty('time_zone');

        $validator
            ->date('date')
            ->allowEmpty('date');

        $validator
            ->scalar('project')
            ->allowEmpty('project');

        $validator
            ->scalar('member')
            ->maxLength('member', 50)
            ->allowEmpty('member');

        $validator
            ->scalar('task')
            ->allowEmpty('task');

        $validator
            ->time('time')
            ->allowEmpty('time');

        $validator
            ->scalar('activity')
            ->maxLength('activity', 10)
            ->allowEmpty('activity');

        $validator
            ->scalar('spent')
            ->maxLength('spent', 20)
            ->allowEmpty('spent');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 5)
            ->allowEmpty('currency');

        $validator
            ->scalar('notes')
            ->allowEmpty('notes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    // public function buildRules(RulesChecker $rules)
    // {
    //     $rules->add($rules->existsIn(['member'], 'Employees'));
    //     return $rules;
    // }
}
