<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Form'), ['action' => 'edit', $form->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Form'), ['action' => 'delete', $form->id], ['confirm' => __('Are you sure you want to delete # {0}?', $form->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Forms'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Form'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Form Fields'), ['controller' => 'FormFields', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Form Field'), ['controller' => 'FormFields', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Form Submissions'), ['controller' => 'FormSubmissions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Form Submission'), ['controller' => 'FormSubmissions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="forms view large-9 medium-8 columns content">
    <h3><?= h($form->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($form->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($form->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($form->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($form->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($form->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($form->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($form->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Form Fields') ?></h4>
        <?php if (!empty($form->form_fields)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Form Id') ?></th>
                <th scope="col"><?= __('Field Data') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($form->form_fields as $formFields): ?>
            <tr>
                <td><?= h($formFields->id) ?></td>
                <td><?= h($formFields->form_id) ?></td>
                <td><?= h($formFields->field_data) ?></td>
                <td><?= h($formFields->created) ?></td>
                <td><?= h($formFields->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FormFields', 'action' => 'view', $formFields->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FormFields', 'action' => 'edit', $formFields->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FormFields', 'action' => 'delete', $formFields->id], ['confirm' => __('Are you sure you want to delete # {0}?', $formFields->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Form Submissions') ?></h4>
        <?php if (!empty($form->form_submissions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Form Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Submitted Data') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($form->form_submissions as $formSubmissions): ?>
            <tr>
                <td><?= h($formSubmissions->id) ?></td>
                <td><?= h($formSubmissions->form_id) ?></td>
                <td><?= h($formSubmissions->employee_id) ?></td>
                <td><?= h($formSubmissions->submitted_data) ?></td>
                <td><?= h($formSubmissions->created) ?></td>
                <td><?= h($formSubmissions->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FormSubmissions', 'action' => 'view', $formSubmissions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FormSubmissions', 'action' => 'edit', $formSubmissions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FormSubmissions', 'action' => 'delete', $formSubmissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $formSubmissions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
<?=  $this->Html->script('../dist/js/jquery.min'); ?>
<?= $this->Html->script('../js/jquery-ui.min.js'); ?>
<script src="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></script> 
 <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
 <?= $this->Html->script('../js/formBuilder/form-builder-code.js'); ?>
