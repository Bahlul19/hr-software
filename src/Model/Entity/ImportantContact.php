<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImportantContact Entity
 *
 * @property int $id
 * @property string $name_of_contact
 * @property string $type
 * @property string $location
 * @property string $role
 * @property string $contact_no
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class ImportantContact extends Entity
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
        'name_of_contact' => true,
        'type' => true,
        'location' => true,
        'role' => true,
        'contact_no' => true,
        'description' => true,
        'created' => true,
        'modified' => true
    ];
}
