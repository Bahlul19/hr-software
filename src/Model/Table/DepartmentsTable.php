<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;


/**
 * Departments Model
 *
 * @property \App\Model\Table\EmployeeDepartmentsTable|\Cake\ORM\Association\HasMany $EmployeeDepartments
 *
 * @method \App\Model\Entity\Department get($primaryKey, $options = [])
 * @method \App\Model\Entity\Department newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Department[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Department|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Department|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Department patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Department[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Department findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DepartmentsTable extends Table
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

        $this->setTable('departments');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('EmployeeDepartments', [
            'foreignKey' => 'department_id'
        ]);
        $this->hasMany('Employees', [
            'foreignKey' => 'department_id'
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
            ->scalar('name')
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmpty('name', 'Please enter a Name')
            ->notBlank('name', 'Name field cannot be blank');

        $validator
            ->scalar('lead')
            ->maxLength('lead', 30)
            ->requirePresence('lead', 'create')
            ->notEmpty('lead', 'Please enter a Leader Name')
            ->notBlank('lead', 'lead field cannot be blank');

        return $validator;
    }

     /**
     * Search by name,employee and lead
     * @param $keyword entered in search box
     * @return $results returns search results
     */
    public function searchByNameAndNoOfEmployeesAndLeadAndStatus($keyword)
    {
        $results = $this->find(
            'all', array('conditions' => [['CONCAT(Departments.name,Departments.lead,Departments.no_of_employees,Departments.status) like' => '%' . $keyword . '%']
                ]
            ));

        return $results;
    }

    /**
     * Increment counter for no of employees field in department
     * @param $deparmentId
     */

    public function incrementDepartmentEmployee($deparmentId)
     {
        $expression = new QueryExpression('no_of_employees = no_of_employees + 1');
        $this->updateAll([$expression],[ 'id'=>$deparmentId]);
     }


    /**
     * Find department by id
     * @param $id
     * */ 
    public function getDepartmentById($id)
    {
        $result = $this->Employees->Departments->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->toArray();
        
        return $result;
    
    }
}
