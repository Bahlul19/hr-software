<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SkillLevel $skillLevel
 */
?>
<br>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Skill Level'), ['action' => 'edit', $skillLevel->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Skill Level'), ['action' => 'delete', $skillLevel->id], ['confirm' => __('Are you sure you want to delete # {0}?', $skillLevel->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Skill Levels'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Skill Level'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employee Skills'), ['controller' => 'EmployeeSkills', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Skill'), ['controller' => 'EmployeeSkills', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="skillLevels view large-9 medium-8 columns content">
    <h3><?= h($skillLevel->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($skillLevel->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($skillLevel->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated') ?></th>
            <td><?= h($skillLevel->updated) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Level Name') ?></h4>
        <?= $this->Text->autoParagraph(h($skillLevel->level_name)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Employee Skills') ?></h4>
        <?php if (!empty($skillLevel->employee_skills)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Skill Id') ?></th>
                <th scope="col"><?= __('Skill Level Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('From Date') ?></th>
                <th scope="col"><?= __('To Date') ?></th>
                <th scope="col"><?= __('Updated By') ?></th>
                <th scope="col"><?= __('Comments') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($skillLevel->employee_skills as $employeeSkills): ?>
            <tr>
                <td><?= h($employeeSkills->id) ?></td>
                <td><?= h($employeeSkills->employee_id) ?></td>
                <td><?= h($employeeSkills->skill_id) ?></td>
                <td><?= h($employeeSkills->skill_level_id) ?></td>
                <td><?= h($employeeSkills->status) ?></td>
                <td><?= h($employeeSkills->from_date) ?></td>
                <td><?= h($employeeSkills->to_date) ?></td>
                <td><?= h($employeeSkills->updated_by) ?></td>
                <td><?= h($employeeSkills->comments) ?></td>
                <td><?= h($employeeSkills->created) ?></td>
                <td><?= h($employeeSkills->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EmployeeSkills', 'action' => 'view', $employeeSkills->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EmployeeSkills', 'action' => 'edit', $employeeSkills->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmployeeSkills', 'action' => 'delete', $employeeSkills->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeSkills->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
