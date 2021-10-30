<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Salary Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property string $employee_name
 * @property int $salary
 * @property string $reason
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Employee $employee
 */
class Salary extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'employee_id' => true,
        'employee_name' => true,
        'salary_amount' => true,
        'reason' => true,
        'designation_id'=>true,
        'is_approved'=>true,
        'approved_by'=>true,
        'is_updated' =>true,
        'updated_by' =>true,
        'modified' => true,
        'created' => true,
        'employee' => true
    ];
}
