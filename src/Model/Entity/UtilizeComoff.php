<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UtilizeComoff Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property string $employee_name
 * @property \Cake\I18n\FrozenTime $date
 * @property float $utilize_hours
 * @property string $approved_by
 * @property int $status
 *
 * @property \App\Model\Entity\Employee $employee
 */
class UtilizeComoff extends Entity
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
        'date' => true,
        'utilize_hours' => true,
        'approved_by' => true,
        'status' => true,
        'employee' => true
    ];
}
