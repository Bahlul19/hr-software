<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Policy Entity
 *
 * @property int $id
 * @property string $title
 * @property string $policies
 * @property string $country
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 */
class Policy extends Entity
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
        'policies' => true,
        'office' => true,
        'is_approved'=>true,
        'is_updated'=>true,
        'updated_by'=>true,
        'approved_by'=>true,
        'modified' => true,
        'created' => true
    ];
}
