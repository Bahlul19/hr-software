<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MinWeekHour $minWeekHour
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $minWeekHour->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $minWeekHour->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Min Week Hours'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="minWeekHours form large-9 medium-8 columns content">
    <?= $this->Form->create($minWeekHour) ?>
    <fieldset>
        <legend><?= __('Edit Min Week Hour') ?></legend>
        <?php
            echo $this->Form->control('office_location');
            echo $this->Form->control('hours');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
