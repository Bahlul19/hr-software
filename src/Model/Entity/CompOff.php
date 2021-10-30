<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompOff Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\FrozenDate $date
 * @property int $number_of_hours
 * @property string $pm_name
 * @property string $team_name
 * @property string $project_task_details
 * @property string $name_of_the_project
 */
class CompOff extends Entity
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
        'name' => true,
        'date' => true,
        'number_of_hours' => true,
        'pm_name' => true,
        'team_name' => true,
        'project_task_details' => true,
        'name_of_the_project' => true,
        'employee_id' => true,
        'pm_id' => true,
        'status' => true,
    ];
}
