<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProcessDocumentation Entity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $office
 * @property string $roles
 * @property string $employee_list
 * @property int $last_updated_by
 * @property string $tags
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class ProcessDocumentation extends Entity
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
        'description' => true,
        'office' => true,
        'roles' => true,
        'employee_list' => true,
        'last_updated_by' => true,
        'tags' => true,
        'created' => true,
        'modified' => true,
        'employee' => true
    ];
}
