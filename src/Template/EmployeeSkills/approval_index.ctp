<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeSkill[]|\Cake\Collection\CollectionInterface $employeeSkills
 */
?>
<div class="employeeSkills index large-9 medium-8 columns content">
    <h3><?= __('Employee Skills') ?></h3>
    <table class="table table-hover table-bordered datatable" id="employee-skill-approve">
        <thead>
            <tr>
                <th scope="col">Employee</th>
                <th scope="col">Skill</th>
                <th scope="col">Skill Level</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Created</th>
                <th scope="col" class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeSkills as $employeeSkill): ?>
            <tr>
                <td><?= $employeeSkill->has('employee') ? $this->Html->link($employeeSkill->employee->first_name, ['controller' => 'Employees', 'action' => 'view', $employeeSkill->employee->id]) : '' ?></td>
                <td><?= $employeeSkill->has('skill') ? $this->Html->link($employeeSkill->skill->skill_name, ['controller' => 'Skills', 'action' => 'view', $employeeSkill->skill->id]) : '' ?></td>
                <td><?= $employeeSkill->has('skill_level') ? h(ucfirst($employeeSkill->skill_level->level_name)) : '' ?></td>
                <td><?= h($employeeSkill->from_date) ?></td>
                <td><?= h($employeeSkill->to_date) ?></td>
                <td><?= h($employeeSkill->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Approve'), ['action' => 'approve_skill', $employeeSkill->id],['class'=>'approve']) ?>
                    <?= $this->Html->link(__('Reject'), ['action' => 'reject_skill', $employeeSkill->id],['class'=>'reject']) ?>
                    <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $employeeSkill->id], ['confirm' => __('Are you sure you want to delete?'),'class'=>'delete','escape'=>false]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
