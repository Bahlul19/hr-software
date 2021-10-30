<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeExperience Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property string $previous_company
 * @property string $duration
 * @property \Cake\I18n\FrozenDate $date_of_service_from
 * @property \Cake\I18n\FrozenDate $date_of_service_to
 * @property int $last_earned_salary
 * @property string $designation
 * @property string $reported_to
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class EmployeeExperience extends Entity
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
        'previous_company' => true,
        'duration' => true,
        'date_of_service_from' => true,
        'date_of_service_to' => true,
        'last_earned_salary' => true,
        'designation' => true,
        'reported_to' => true,
        'created' => true,
        'modified' => true,
        'employee' => true
    ];
}
