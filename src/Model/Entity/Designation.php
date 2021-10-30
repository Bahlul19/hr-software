<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Designation Entity
 *
 * @property int $id
 * @property string $title
 * @property int $no_of_employees
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EmployeeDesignation[] $employee_designations
 */
class Designation extends Entity
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
        'title' => true,
        'no_of_employees' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'employee_designations' => true
    ];
}
