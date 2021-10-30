<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Skill Entity
 *
 * @property int $id
 * @property string $skill_name
 * @property string $skill_level_ids
 * @property string $version
 * @property string $image
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EmployeeSkill[] $employee_skills
 */
class Skill extends Entity
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
        'skill_name' => true,
        'skill_category_id' => true,
        'skill_level_ids' => true,
        'version' => true,
        'image' => true,
        'created' => true,
        'modified' => true,
        'employee_skills' => true
    ];
}
