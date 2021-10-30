<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveDay[]|\Cake\Collection\CollectionInterface $leaveDays
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Leave Day'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="leaveDays index large-9 medium-8 columns content">
    <h3><?= __('Leave Days') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sick_leave') ?></th>
                <th scope="col"><?= $this->Paginator->sort('casual_leave') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lwop_leave') ?></th>
                <th scope="col"><?= $this->Paginator->sort('earned_leave') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leaveDays as $leaveDay): ?>
            <tr>
                <td><?= $this->Number->format($leaveDay->id) ?></td>
                <td><?= $leaveDay->has('employee') ? $this->Html->link($leaveDay->employee->id, ['controller' => 'Employees', 'action' => 'view', $leaveDay->employee->id]) : '' ?></td>
                <td><?= $this->Number->format($leaveDay->sick_leave) ?></td>
                <td><?= $this->Number->format($leaveDay->casual_leave) ?></td>
                <td><?= $this->Number->format($leaveDay->lwop_leave) ?></td>
                <td><?= $this->Number->format($leaveDay->earned_leave) ?></td>
                <td><?= h($leaveDay->created_by) ?></td>
                <td><?= h($leaveDay->updated_by) ?></td>
                <td><?= h($leaveDay->created) ?></td>
                <td><?= h($leaveDay->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $leaveDay->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $leaveDay->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $leaveDay->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveDay->id)]) ?>
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
