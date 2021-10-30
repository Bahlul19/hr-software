<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormField $formField
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Form Field'), ['action' => 'edit', $formField->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Form Field'), ['action' => 'delete', $formField->id], ['confirm' => __('Are you sure you want to delete # {0}?', $formField->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Form Fields'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Form Field'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Forms'), ['controller' => 'Forms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Form'), ['controller' => 'Forms', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="formFields view large-9 medium-8 columns content">
    <h3><?= h($formField->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Form') ?></th>
            <td><?= $formField->has('form') ? $this->Html->link($formField->form->title, ['controller' => 'Forms', 'action' => 'view', $formField->form->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($formField->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($formField->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($formField->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Field Data') ?></h4>
        <?= $this->Text->autoParagraph(h($formField->field_data)); ?>
    </div>
</div>
<?= $this->Html->script('../dist/js/jquery.min'); ?>
<?= $this->Html->script('../js/jquery-ui.min.js'); ?>
<script src="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></script> 
 <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
 <?= $this->Html->script('../js/formBuilder/form-builder-code.js'); ?>