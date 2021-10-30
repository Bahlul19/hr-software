<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Announcement Entity
 *
 * @property int $id
 * @property string $announcement
 * @property \Cake\I18n\FrozenDate $date
 * @property string $offices
 */
class Announcement extends Entity
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
        'id' => true,
        'announcement' => true,
        'start_date' => true,
        'end_date' => true,
        'offices' => true,
        'title' => true
    ];
}
