<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormField $formField
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Form Fields'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Forms'), ['controller' => 'Forms', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Form'), ['controller' => 'Forms', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="formFields form large-9 medium-8 columns content">
    <?= $this->Form->create($formField) ?>
    <fieldset>
        <legend><?= __('Add Form Field') ?></legend>
        <?php
            echo $this->Form->control('form_id', ['options' => $forms]);
            echo $this->Form->control('field_data');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?=  $this->Html->script('../dist/js/jquery.min'); ?>
<?= $this->Html->script('../js/jquery-ui.min.js'); ?>
<script src="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></script> 
 <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
 <?= $this->Html->script('../js/formBuilder/form-builder-code.js'); ?>