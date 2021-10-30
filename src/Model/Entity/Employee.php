<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
/**
 * Employee Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $emp_id
 * @property string $personal_email
 * @property string $office_email
 * @property string $password
 * @property string $present_address
 * @property string $permanent_address
 * @property int $mobile_number
 * @property int $alternate_number
 * @property int $emergency_number
 * @property string $country
 * @property string $office_location
 * @property int $gender
 * @property \Cake\I18n\FrozenDate $birth_date
 * @property \Cake\I18n\FrozenDate $birth_date2
 * @property string $maritial_status
 * @property string $identity_proof
 * @property string $blood_group
 * @property string $bank_name
 * @property string $bank_account_number
 * @property int $salary
 * @property string $tax_bracket
 * @property string $languages
 * @property string $max_qualification
 * @property int $designation_id
 * @property string $shift_type
 * @property int $department_id
 * @property string $reporting_manager
 * @property string $mentor
 * @property \Cake\I18n\FrozenDate $date_of_joining
 * @property string $source_of_hire
 * @property string $referred_by
 * @property string $employment_status
 * @property string $work_phone
 * @property string $employment_type
 * @property \Cake\I18n\FrozenDate $confirmation_date
 * @property int $designation_change
 * @property \Cake\I18n\FrozenDate $designation_change_date
 * @property \Cake\I18n\FrozenDate $increment_date
 * @property \Cake\I18n\FrozenDate $resignation_date
 * @property \Cake\I18n\FrozenDate $last_working_date
 * @property string $notice_period
 * @property string $reason
 * @property string $blacklisted
 * @property string $reporitng_manager_responsibilities
 * @property string $notes
 * @property string $knowledge
 * @property string $hubstaff_name
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Emp $emp
 * @property \App\Model\Entity\Designation $designation
 * @property \App\Model\Entity\Department $department
 * @property \App\Model\Entity\EmployeeEducation[] $employee_education
 * @property \App\Model\Entity\EmployeeExperience[] $employee_experience
 * @property \App\Model\Entity\LeaveRequest[] $leave_requests
 */
class Employee extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'emp_id' => true,
        'personal_email' => true,
        'office_email' => true,
        'password' => true,
        'present_address' => true,
        'permanent_address' => true,
        'mobile_number' => true,
        'alternate_number' => true,
        'emergency_number' => true,
        'country' => true,
        'office_location' => true,
        'gender' => true,
        'birth_date' => true,
        'birth_date2' => true,
        'maritial_status' => true,
        'identity_proof' => true,
        'blood_group' => true,
        'bank_name' => true,
        'bank_account_number' => true,
        //'salary' => true,
        'tax_bracket' => true,
        'languages' => true,
        'max_qualification' => true,
        'designation_id' => true,
        'shift_type' => true,
        'department_id' => true,
        // '' => true,
        'reporting_manager' => true,
        'reporting_manager_responsibilities' => true,
        'mentor' => true,
        'date_of_joining' => true,
        'source_of_hire' => true,
        'referred_by' => true,
        'employment_status' => true,
        'work_phone' => true,
        'employment_type' => true,
        'confirmation_date' => true,
        'designation_change' => true,
        'designation_change_date' => true,
        'increment_date' => true,
        'resignation_date' => true,
        'last_working_date' => true,
        'notice_period' => true,
        'reason' => true,
        'blacklisted' => true,
        'notes' => true,
        'knowledge' => true,
        'created' => true,
        'modified' => true,
        'emp' => true,
        'designation' => true,
        'department' => true,
        'employee_education' => true,
        'employee_experience' => true,
        'leave_requests' => true,
        'reporting_team' => true,
        'role_id' => true,
        'hubstaff_name'=>true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    
     /**
     * @param string|null $password passwords.
     *converts plain text
     *@return hashed password for database storage
     * Converts password to has format
     *
     * @var array
     */

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
