<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PasswordRetrieve Entity
 *
 * @property int $id
 * @property string $user_email
 * @property int $user_id
 * @property string $sec_token
 * @property \Cake\I18n\FrozenTime $request_date_time
 * @property \Cake\I18n\FrozenTime $change_date_time
 *
 * @property \App\Model\Entity\User $user
 */
class PasswordRetrieve extends Entity
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
        'user_email' => true,
        'user_id' => true,
        'sec_token' => true,
        'request_date_time' => true,
        'change_date_time' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'sec_token'
    ];
}
