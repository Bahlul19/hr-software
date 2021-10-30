<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LeaveRequest Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property string $leave_type
 * @property \Cake\I18n\FrozenDate $date_from
 * @property \Cake\I18n\FrozenDate $date_to
 * @property float $no_of_days
 * @property int $available_leave
 * @property string $status
 * @property string $leave_reason
 * @property int $late_apply
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class LeaveRequest extends Entity
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
        'reporting_managerId' => true,
        'leave_type' => true,
        'date_from' => true,
        'date_to' => true,
        'no_of_days' => true,
        'half_day' => true,
        'leave_reason' => true,
        'approved_by' => true,
        'reliever' => true,
        'reject_request' => true,
        'created' => true,
        'modified' => true,
        'employee' => true

    ];
}
