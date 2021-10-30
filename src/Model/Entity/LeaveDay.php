<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LeaveDay Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property int $sick_leave
 * @property int $casual_leave
 * @property int $lwop_leave
 * @property int $earned_leave
 * @property string $created_by
 * @property string $updated_by
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class LeaveDay extends Entity
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
        'sick_leave' => true,
        'casual_leave' => true,
        'earned_leave' => true,
        'planned_leave'=>true,
        'unplanned_leave'=>true,
        'restricted_leave'=>true,
        'day_off'=>true,
        'created_by' => true,
        'updated_by' => true,
        'created' => true,
        'modified' => true,
        'employee' => true
    ];
}
