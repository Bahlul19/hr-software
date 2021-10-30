<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmpLeave Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property string $employee_name
 * @property int|null $reporting_managerId
 * @property int $leave_type
 * @property \Cake\I18n\FrozenTime $date_from
 * @property \Cake\I18n\FrozenTime $date_to
 * @property float $no_of_days
 * @property int $half_day
 * @property string $leave_reason
 * @property int $sick_leave_taken
 * @property int $casual_leave_taken
 * @property int $lwop_leave_taken
 * @property int $earned_leave_taken
 * @property int $unplanned_leave_taken
 * @property int $planned_leave_taken
 * @property int $restricted_leave_taken
 * @property int $day_off_taken
 * @property int $half_day_taken
 * @property int $is_approved
 * @property string $approved_by
 * @property string $reliever
 * @property string $reliever_name
 * @property string $reliever_status
 * @property string $reliever_approved
 * @property string $reliever_rejected
 * @property string $test
 * @property string $reject_reason
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class EmpLeave extends Entity
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
        'sick_leave_taken' => true,
        'casual_leave_taken' => true,
        'lwop_leave_taken' => true,
        'earned_leave_taken' => true,
        'unplanned_leave_taken' => true,
        'planned_leave_taken' => true,
        'restricted_leave_taken' => true,
        'day_off_taken' => true,
        'half_day_taken' => true,
        'is_approved' => true,
        'approved_by' => true,
        'reliever' => true,
        'reliever_name' => true,
        'reliever_status' => true,
        'reliever_approved' => true,
        'reliever_rejected' => true,
        'test' => true,
        'approved_or_rejected' => true,
        'reject_reason' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'employee' => true
    ];
}
