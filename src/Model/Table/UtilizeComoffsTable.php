<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * UtilizeComoffs Model
 *
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\UtilizeComoff get($primaryKey, $options = [])
 * @method \App\Model\Entity\UtilizeComoff newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UtilizeComoff[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UtilizeComoff|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UtilizeComoff|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UtilizeComoff patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UtilizeComoff[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UtilizeComoff findOrCreate($search, callable $callback = null, $options = [])
 */
class UtilizeComoffsTable extends Table
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

        $this->setTable('utilize_comoffs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));

        return $rules;
    }

    public function employeeNameFromId($id = null) {
        $employees = TableRegistry::get('Employees');
        $employee = $employees->find('all')->WHERE(['id'=>$id])->toArray();

        $name = array();
        foreach ($employee as $e){
            $name = $e['first_name']." ".$e['last_name'];
        }

        return $name;
    }

    public function getApprovedCompoffHourFromId($employeeId) {
        $approvedCompoff = TableRegistry::get('ApprovedCompoff');

        $approvedCompoff = $approvedCompoff->find('all', [ 'conditions' => ['ApprovedCompoff.employee_id' => $employeeId]])->first();

        if($approvedCompoff == null) {
            return 0;
        }
        else {
            $approvedHour = $approvedCompoff->approved_hour;
            return $approvedHour;
        }
    }
}
