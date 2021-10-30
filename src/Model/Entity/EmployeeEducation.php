<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeEducation Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property string $educational_institute_name
 * @property string $duration
 * @property \Cake\I18n\FrozenDate $year_of_completion
 * @property string $certification
 * @property string $percentage
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class EmployeeEducation extends Entity
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
        'educational_institute_name' => true,
        'duration' => true,
        'year_of_completion' => true,
        'certification' => true,
        'percentage' => true,
        'created' => true,
        'modified' => true,
        'employee' => true
    ];
}
