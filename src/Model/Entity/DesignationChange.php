<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DesignationChange Entity
 *
 * @property int $id
 * @property int|null $employee_id
 * @property string $designation_change
 * @property string $change_date
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class DesignationChange extends Entity
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
        'designation_change' => true,
        'change_date' => true,
        'created' => true,
        'modified' => true,
        'employee' => true
    ];
}
