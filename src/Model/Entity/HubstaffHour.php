<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HubstaffHour Entity
 *
 * @property int $id
 * @property string $organization
 * @property string $time_zone
 * @property \Cake\I18n\FrozenDate $date
 * @property string $project
 * @property string $member
 * @property int $task_id
 * @property string $task
 * @property \Cake\I18n\FrozenTime $time
 * @property string $activity
 * @property string $spent
 * @property string $currency
 * @property string $notes
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class HubstaffHour extends Entity
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
        'organization' => true,
        'time_zone' => true,
        'date' => true,
        'project' => true,
        'member' => true,
        'task_id' => true,
        'task' => true,
        'time' => true,
        'activity' => true,
        'spent' => true,
        'currency' => true,
        'notes' => true,
        'created' => true,
        'modified' => true
    ];
}
