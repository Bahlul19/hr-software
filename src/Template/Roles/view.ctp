<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roles view large-9 medium-8 columns content">
    <h3><?= h($role->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= h($role->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($role->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($role->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified At') ?></th>
            <td><?= h($role->modified_at) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Employees') ?></h4>
        <?php if (!empty($role->employees)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('First Name') ?></th>
                <th scope="col"><?= __('Last Name') ?></th>
                <th scope="col"><?= __('Emp Id') ?></th>
                <th scope="col"><?= __('Personal Email') ?></th>
                <th scope="col"><?= __('Office Email') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Present Address') ?></th>
                <th scope="col"><?= __('Permanent Address') ?></th>
                <th scope="col"><?= __('Mobile Number') ?></th>
                <th scope="col"><?= __('Alternate Number') ?></th>
                <th scope="col"><?= __('Emergency Number') ?></th>
                <th scope="col"><?= __('Country') ?></th>
                <th scope="col"><?= __('Office Location') ?></th>
                <th scope="col"><?= __('Gender') ?></th>
                <th scope="col"><?= __('Birth Date') ?></th>
                <th scope="col"><?= __('Maritial Status') ?></th>
                <th scope="col"><?= __('Identity Proof') ?></th>
                <th scope="col"><?= __('Blood Group') ?></th>
                <th scope="col"><?= __('Nid No') ?></th>
                <th scope="col"><?= __('Bank Account Number') ?></th>
                <th scope="col"><?= __('Salary') ?></th>
                <th scope="col"><?= __('Tax Bracket') ?></th>
                <th scope="col"><?= __('Languages') ?></th>
                <th scope="col"><?= __('Max Qualification') ?></th>
                <th scope="col"><?= __('Designation Id') ?></th>
                <th scope="col"><?= __('Shift Type') ?></th>
                <th scope="col"><?= __('Department Id') ?></th>
                <th scope="col"><?= __('Reporting Team') ?></th>
                <th scope="col"><?= __('Reporting Manager') ?></th>
                <th scope="col"><?= __('Reporting Manager Responsibilities') ?></th>
                <th scope="col"><?= __('Mentor') ?></th>
                <th scope="col"><?= __('Date Of Joining') ?></th>
                <th scope="col"><?= __('Source Of Hire') ?></th>
                <th scope="col"><?= __('Referred By') ?></th>
                <th scope="col"><?= __('Employment Status') ?></th>
                <th scope="col"><?= __('Work Phone') ?></th>
                <th scope="col"><?= __('Employment Type') ?></th>
                <th scope="col"><?= __('Confirmation Date') ?></th>
                <th scope="col"><?= __('Designation Change') ?></th>
                <th scope="col"><?= __('Designation Change Date') ?></th>
                <th scope="col"><?= __('Increment Date') ?></th>
                <th scope="col"><?= __('Resignation Date') ?></th>
                <th scope="col"><?= __('Last Working Date') ?></th>
                <th scope="col"><?= __('Notice Period') ?></th>
                <th scope="col"><?= __('Reason') ?></th>
                <th scope="col"><?= __('Blacklisted') ?></th>
                <th scope="col"><?= __('Notes') ?></th>
                <th scope="col"><?= __('Knowledge') ?></th>
                <th scope="col"><?= __('Role Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($role->employees as $employees): ?>
            <tr>
                <td><?= h($employees->id) ?></td>
                <td><?= h($employees->first_name) ?></td>
                <td><?= h($employees->last_name) ?></td>
                <td><?= h($employees->emp_id) ?></td>
                <td><?= h($employees->personal_email) ?></td>
                <td><?= h($employees->office_email) ?></td>
                <td><?= h($employees->password) ?></td>
                <td><?= h($employees->present_address) ?></td>
                <td><?= h($employees->permanent_address) ?></td>
                <td><?= h($employees->mobile_number) ?></td>
                <td><?= h($employees->alternate_number) ?></td>
                <td><?= h($employees->emergency_number) ?></td>
                <td><?= h($employees->country) ?></td>
                <td><?= h($employees->office_location) ?></td>
                <td><?= h($employees->gender) ?></td>
                <td><?= date('m/d/Y',strtotime(h($employees->birth_date))) ?></td>
                <td><?= h($employees->maritial_status) ?></td>
                <td><?= h($employees->identity_proof) ?></td>
                <td><?= h($employees->blood_group) ?></td>
                <td><?= h($employees->nid_no) ?></td>
                <td><?= h($employees->bank_account_number) ?></td>
                <td><?= h($employees->salary) ?></td>
                <td><?= h($employees->tax_bracket) ?></td>
                <td><?= h($employees->languages) ?></td>
                <td><?= h($employees->max_qualification) ?></td>
                <td><?= h($employees->designation_id) ?></td>
                <td><?= h($employees->shift_type) ?></td>
                <td><?= h($employees->department_id) ?></td>
                <td><?= h($employees->reporting_team) ?></td>
                <td><?= h($employees->reporting_manager) ?></td>
                <td><?= h($employees->reporting_manager_responsibilities) ?></td>
                <td><?= h($employees->mentor) ?></td>
                <td><?= date('m/d/Y',strtotime(h($employees->date_of_joining))) ?></td>
                <td><?= h($employees->source_of_hire) ?></td>
                <td><?= h($employees->referred_by) ?></td>
                <td><?= h($employees->employment_status) ?></td>
                <td><?= h($employees->work_phone) ?></td>
                <td><?= h($employees->employment_type) ?></td>
                <td><?= date('m/d/Y',strtotime(h($employees->confirmation_date))) ?></td>
                <td><?= h($employees->designation_change) ?></td>
                <td><?= date('m/d/Y', strtotime(h($employees->designation_change_date))) ?></td>
                <td><?= date('m/d/Y', strtotime(h($employees->increment_date))) ?></td>
                <td><?= date('m/d/Y', strtotime(h($employees->resignation_date))) ?></td>
                <td><?= date('m/d/Y', strtotime(h($employees->last_working_date))) ?></td>
                <td><?= h($employees->notice_period) ?></td>
                <td><?= h($employees->reason) ?></td>
                <td><?= h($employees->blacklisted) ?></td>
                <td><?= h($employees->notes) ?></td>
                <td><?= h($employees->knowledge) ?></td>
                <td><?= h($employees->role_id) ?></td>
                <td><?= h($employees->created) ?></td>
                <td><?= h($employees->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Employees', 'action' => 'view', $employees->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Employees', 'action' => 'edit', $employees->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Employees', 'action' => 'delete', $employees->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employees->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
