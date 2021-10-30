<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeSkill Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property int $skill_id
 * @property int $skill_level_id
 * @property int $status
 * @property \Cake\I18n\FrozenDate $from_date
 * @property \Cake\I18n\FrozenDate $to_date
 * @property int $updated_by
 * @property string $comments
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\Skill $skill
 * @property \App\Model\Entity\SkillLevel $skill_level
 */
class EmployeeSkill extends Entity
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
        'skill_id' => true,
        'skill_level_id' => true,
        'status' => true,
        'from_date' => true,
        'to_date' => true,
        'updated_by' => true,
        'comments' => true,
        'created' => true,
        'modified' => true,
        'employee' => true,
        'skill' => true,
        'skill_level' => true
    ];
}
