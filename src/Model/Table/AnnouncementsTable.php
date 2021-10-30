<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Announcements Model
 *
 * @method \App\Model\Entity\Announcement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Announcement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Announcement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Announcement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Announcement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Announcement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Announcement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Announcement findOrCreate($search, callable $callback = null, $options = [])
 */
class AnnouncementsTable extends Table
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
        $this->addBehavior('Timestamp');
        $this->setTable('announcements');
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
            ->scalar('announcement')
            ->requirePresence('announcement', 'create')
            ->notEmpty('announcement','Please enter announcement')
            ->notBlank('announcement', 'Announcement cannot be blank');

        $validator
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');
        
        $validator
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');    

        $validator
            ->scalar('offices')
            ->requirePresence('offices', 'create')
            ->notEmpty('offices');

        return $validator;
    }



    /**
     * Search by announcement and offices
     * @param $keyword entered in search box
     * @return $results returns search results
     */
    public function announcementsSearchResults($keyword)
    {
        $results = $this->find(
            'all', array('conditions' => [['CONCAT(Announcements.title,Announcements.offices) like' => '%' . $keyword . '%']
                ]
            ));

        return $results;
    }
}
