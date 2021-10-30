<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PasswordRetrieve $passwordRetrieve
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $passwordRetrieve->tble_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $passwordRetrieve->tble_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Password Retrieve'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="passwordRetrieve form large-9 medium-8 columns content">
    <?= $this->Form->create($passwordRetrieve) ?>
    <fieldset>
        <legend><?= __('Edit Password Retrieve') ?></legend>
        <?php
            echo $this->Form->control('user_email');
            echo $this->Form->control('user_id');
            echo $this->Form->control('token');
            echo $this->Form->control('request_date_time');
            echo $this->Form->control('change_date_time');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
