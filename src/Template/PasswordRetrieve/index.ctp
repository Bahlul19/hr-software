<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PasswordRetrieve[]|\Cake\Collection\CollectionInterface $passwordRetrieve
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Password Retrieve'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="passwordRetrieve index large-9 medium-8 columns content">
    <h3><?= __('Password Retrieve') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('tble_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('token') ?></th>
                <th scope="col"><?= $this->Paginator->sort('request_date_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('change_date_time') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($passwordRetrieve as $passwordRetrieve): ?>
            <tr>
                <td><?= $this->Number->format($passwordRetrieve->tble_id) ?></td>
                <td><?= h($passwordRetrieve->user_email) ?></td>
                <td><?= $this->Number->format($passwordRetrieve->user_id) ?></td>
                <td><?= h($passwordRetrieve->token) ?></td>
                <td><?= h($passwordRetrieve->request_date_time) ?></td>
                <td><?= h($passwordRetrieve->change_date_time) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $passwordRetrieve->tble_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $passwordRetrieve->tble_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $passwordRetrieve->tble_id], ['confirm' => __('Are you sure you want to delete # {0}?', $passwordRetrieve->tble_id)]) ?>
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
