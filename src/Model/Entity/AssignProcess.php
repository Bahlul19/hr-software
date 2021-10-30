<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssignProcess Entity
 *
 * @property int $id
 * @property int $process_id
 * @property int $employee_id
 * @property string $office
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ProcessDocumentation $process_documentation
 * @property \App\Model\Entity\Employee $employee
 */
class AssignProcess extends Entity
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
        'process_id' => true,
        'employee_id' => true,
        'office' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'process_documentation' => true,
        'employee' => true
    ];
}
