<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeAttendance Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property string $employee_name
 * @property string $shift
 * @property \Cake\I18n\FrozenTime $shift_start_at
 * @property \Cake\I18n\FrozenTime $shift_end_at
 * @property \Cake\I18n\FrozenDate $date
 * @property \Cake\I18n\FrozenTime $checkin
 * @property \Cake\I18n\FrozenTime $checkout
 * @property string $hours_worked
 * @property \Cake\I18n\FrozenTime $extra_hours
 * @property \Cake\I18n\FrozenTime $less_hours
 * @property \Cake\I18n\FrozenTime $late_by
 * @property \Cake\I18n\FrozenTime $early_by
 * @property bool $is_present
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class EmployeeAttendance extends Entity
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
        'shift' => true,
        'shift_start_at' => true,
        'shift_end_at' => true,
        'date' => true,
        'checkin' => true,
        'checkout' => true,
        'hours_worked' => true,
        'extra_hours' => true,
        'less_hours' => true,
        'late_by' => true,
        'early_by' => true,
        'is_present' => true,
        'created' => true,
        'modified' => true,
        'employee' => true
    ];
}
