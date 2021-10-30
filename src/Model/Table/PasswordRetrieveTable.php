<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PasswordRetrieve Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\PasswordRetrieve get($primaryKey, $options = [])
 * @method \App\Model\Entity\PasswordRetrieve newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PasswordRetrieve[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PasswordRetrieve|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PasswordRetrieve|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PasswordRetrieve patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PasswordRetrieve[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PasswordRetrieve findOrCreate($search, callable $callback = null, $options = [])
 */
class PasswordRetrieveTable extends Table
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

        $this->setTable('password_retrieve');
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
            ->scalar('user_email')
            ->maxLength('user_email', 255)
            ->requirePresence('user_email', 'create')
            ->notEmpty('user_email')
            ->add('user_email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('sec_token')
            ->maxLength('sec_token', 255)
            ->requirePresence('sec_token', 'create')
            ->notEmpty('sec_token');

        $validator
            ->dateTime('request_date_time')
            ->requirePresence('request_date_time', 'create')
            ->notEmpty('request_date_time');

        $validator
            ->dateTime('change_date_time')
            ->requirePresence('change_date_time', 'create')
            ->notEmpty('change_date_time');

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
        $rules->add($rules->isUnique(['user_email']));
        // $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
