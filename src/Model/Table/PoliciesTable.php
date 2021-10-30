<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Policies Model
 *
 * @method \App\Model\Entity\Policy get($primaryKey, $options = [])
 * @method \App\Model\Entity\Policy newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Policy[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Policy|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Policy|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Policy patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Policy[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Policy findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PoliciesTable extends Table
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

        $this->setTable('policies');
        $this->setDisplayField('title');
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('policies')
            ->requirePresence('policies', 'create')
            ->notEmpty('policies');

        $validator
            ->scalar('office')
            ->maxLength('office', 100)
            ->requirePresence('office', 'create')
            ->notEmpty('office');

        return $validator;
    }

    /**
     * Search by announcement and offices
     * @param $keyword entered in search box
     * @return $results returns search results
     */
    public function policySearchResults($keyword)
    {
        $results = $this->find(
            'all', array('conditions' => [['CONCAT(Policies.title,Policies.country) like' => '%' . $keyword . '%']
        ]
        ));

        return $results;
    }
}
