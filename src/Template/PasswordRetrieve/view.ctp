<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PasswordRetrieve $passwordRetrieve
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Password Retrieve'), ['action' => 'edit', $passwordRetrieve->tble_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Password Retrieve'), ['action' => 'delete', $passwordRetrieve->tble_id], ['confirm' => __('Are you sure you want to delete # {0}?', $passwordRetrieve->tble_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Password Retrieve'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Password Retrieve'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="passwordRetrieve view large-9 medium-8 columns content">
    <h3><?= h($passwordRetrieve->tble_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User Email') ?></th>
            <td><?= h($passwordRetrieve->user_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Token') ?></th>
            <td><?= h($passwordRetrieve->token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tble Id') ?></th>
            <td><?= $this->Number->format($passwordRetrieve->tble_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($passwordRetrieve->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Request Date Time') ?></th>
            <td><?= h($passwordRetrieve->request_date_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Change Date Time') ?></th>
            <td><?= h($passwordRetrieve->change_date_time) ?></td>
        </tr>
    </table>
</div>
