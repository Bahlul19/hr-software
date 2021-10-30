<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FormField Entity
 *
 * @property int $id
 * @property int $form_id
 * @property string $field_data
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Form $form
 */
class FormField extends Entity
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
        'form_id' => true,
        'field_data' => true,
        'created' => true,
        'modified' => true,
        'form' => true
    ];
}
