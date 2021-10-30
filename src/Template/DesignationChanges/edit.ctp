<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DesignationChange $designationChange
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $designationChange->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $designationChange->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Designation Changes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="designationChanges form large-9 medium-8 columns content">
    <?= $this->Form->create($designationChange) ?>
    <fieldset>
        <legend><?= __('Edit Designation Change') ?></legend>
        <?php
            echo $this->Form->control('employee_id', ['options' => $employees, 'empty' => true]);
            echo $this->Form->control('designation_change');
            echo $this->Form->control('change_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
