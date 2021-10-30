<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DesignationChange[]|\Cake\Collection\CollectionInterface $designationChanges
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Designation Change'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="designationChanges index large-9 medium-8 columns content">
    <h3><?= __('Designation Changes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('designation_change') ?></th>
                <th scope="col"><?= $this->Paginator->sort('change_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($designationChanges as $designationChange): ?>
            <tr>
                <td><?= $this->Number->format($designationChange->id) ?></td>
                <td><?= $designationChange->has('employee') ? $this->Html->link($designationChange->employee->id, ['controller' => 'Employees', 'action' => 'view', $designationChange->employee->id]) : '' ?></td>
                <td><?= h($designationChange->designation_change) ?></td>
                <td><?= date('m/d/Y',strtotime(h($designationChange->change_date))) ?></td>
                <td><?= date('m/d/Y',strtotime(h($designationChange->created))) ?></td>
                <td><?= date('m/d/Y',strtotime(h($designationChange->modified))) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $designationChange->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $designationChange->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $designationChange->id], ['confirm' => __('Are you sure you want to delete # {0}?', $designationChange->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
