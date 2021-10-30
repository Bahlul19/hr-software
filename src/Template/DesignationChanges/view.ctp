<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DesignationChange $designationChange
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Designation Change'), ['action' => 'edit', $designationChange->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Designation Change'), ['action' => 'delete', $designationChange->id], ['confirm' => __('Are you sure you want to delete # {0}?', $designationChange->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Designation Changes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Designation Change'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="designationChanges view large-9 medium-8 columns content">
    <h3><?= h($designationChange->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Employee') ?></th>
            <td><?= $designationChange->has('employee') ? $this->Html->link($designationChange->employee->id, ['controller' => 'Employees', 'action' => 'view', $designationChange->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Designation Change') ?></th>
            <td><?= h($designationChange->designation_change) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Change Date') ?></th>
            <td><?= date('m/d/Y',strtotime(h($designationChange->change_date))) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($designationChange->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= date('m/d/Y',strtotime(h($designationChange->created))) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= date('m/d/Y',strtotime(h($designationChange->modified))) ?></td>
        </tr>
    </table>
</div>
