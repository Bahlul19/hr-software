<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;

/**
 * Designations Model
 *
 * @property \App\Model\Table\EmployeeDesignationsTable|\Cake\ORM\Association\HasMany $EmployeeDesignations
 *
 * @method \App\Model\Entity\Designation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Designation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Designation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Designation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Designation|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Designation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Designation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Designation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DesignationsTable extends Table
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

        $this->setTable('designations');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('EmployeeDesignations', [
            'foreignKey' => 'designation_id'
        ]);
        $this->hasMany('Employees', [
            'foreignKey' => 'designation_id',
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
            ->maxLength('title', 255)
            ->notEmpty('title', 'Please enter a title')
            ->notBlank('title', 'Title field cannot be blank');

        return $validator;
    }

    /**
     * Search by title and employee
     * @param $keyword entered in search box
     * @return $results returns search results
     */
    public function searchByTitleAndNoOfEmployeesAndStatus($keyword)
    {
        $results = $this->find(
            'all', array('conditions' => [['CONCAT(Designations.title,Designations.no_of_employees,Designations.status) like' => '%' . $keyword . '%']] ));

        return $results;
    }

    /**
     * Increment counter for no of employees field in designation
     * @param $designationId
     */

    public function incrementDesiginationEmployee($designationId)
     {
        $expression = new QueryExpression('no_of_employees = no_of_employees + 1');
        $this->updateAll([$expression],[ 'id'=>$designationId]);
     }
}
