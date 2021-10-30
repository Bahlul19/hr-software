<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Form Entity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $status
 * @property string $slug
 * @property \Cake\I18n\FrozenDate $available_from
 * @property \Cake\I18n\FrozenDate $available_to
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\FormFeedbackFor[] $form_feedback_for
 * @property \App\Model\Entity\FormField $form_field
 * @property \App\Model\Entity\FormSubmission[] $form_submissions
 * @property \App\Model\Entity\FormVisibility[] $form_visibility
 */
class Form extends Entity
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
        'status' => true,
        'slug' => true,
        'available_from' => true,
        'available_to' => true,
        'created_by' => true,
        'created' => true,
        'modified' => true,
        'form_feedback_for' => true,
        'form_field' => true,
        'form_submissions' => true,
        'form_visibility' => true
    ];
}
