<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MinWeekHours Model
 *
 * @method \App\Model\Entity\MinWeekHour get($primaryKey, $options = [])
 * @method \App\Model\Entity\MinWeekHour newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MinWeekHour[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MinWeekHour|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MinWeekHour|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MinWeekHour patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MinWeekHour[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MinWeekHour findOrCreate($search, callable $callback = null, $options = [])
 */
class MinWeekHoursTable extends Table
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

        $this->setTable('min_week_hours');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('office_location')
            ->maxLength('office_location', 20)
            ->requirePresence('office_location', 'create')
            ->notEmpty('office_location');

        $validator
            ->numeric('hours')
            ->requirePresence('hours', 'create')
            ->notEmpty('hours');

        return $validator;
    }
}
