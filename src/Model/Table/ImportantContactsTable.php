<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImportantContacts Model
 *
 * @method \App\Model\Entity\ImportantContact get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImportantContact newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ImportantContact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImportantContact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportantContact|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportantContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImportantContact[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImportantContact findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ImportantContactsTable extends Table
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

        $this->setTable('important_contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('name_of_contact')
            ->requirePresence('name_of_contact', 'create')
            ->notEmpty('name_of_contact');

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('location')
            ->maxLength('location', 20)
            ->allowEmpty('location');

        $validator
            ->scalar('role')
            ->maxLength('role', 10)
            ->requirePresence('role', 'create')
            ->notEmpty('role');

        $validator
            ->scalar('contact_no')
            ->maxLength('contact_no', 15)
            ->requirePresence('contact_no', 'create')
            ->notEmpty('contact_no');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        return $validator;
    }
}
