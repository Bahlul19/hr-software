<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MinWeekHour[]|\Cake\Collection\CollectionInterface $minWeekHours
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Min Week Hour'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="minWeekHours index large-9 medium-8 columns content">
    <h3><?= __('Min Week Hours') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('office_location') ?></th>
                <th scope="col"><?= $this->Paginator->sort('hours') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($minWeekHours as $minWeekHour): ?>
            <tr>
                <td><?= $this->Number->format($minWeekHour->id) ?></td>
                <td><?= h($minWeekHour->office_location) ?></td>
                <td><?= $this->Number->format($minWeekHour->hours) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $minWeekHour->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $minWeekHour->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $minWeekHour->id], ['confirm' => __('Are you sure you want to delete # {0}?', $minWeekHour->id)]) ?>
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
