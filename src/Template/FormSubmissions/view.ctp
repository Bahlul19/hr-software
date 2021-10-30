<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormSubmission $formSubmission
 */
?>
<div class="formSubmissions view large-9 medium-8 columns content">
    <h3><?= h($formSubmission->form->title) ?> </h3>
    <?php if($role!=4){
       ?>
        <!-- <h5>Submitted By <?php // h($formSubmission->employees_a->first_name. ' '.$formSubmission->employees_a->last_name) ?></h5> -->
    <?php } ?>
    <!-- <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Form') ?></th>
            <td><?= $formSubmission->has('form') ? $this->Html->link($formSubmission->form->title, ['controller' => 'Forms', 'action' => 'view', $formSubmission->form->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Employee') ?></th>
            <td><?= $formSubmission->has('employee') ? $this->Html->link($formSubmission->employee->id, ['controller' => 'Employees', 'action' => 'view', $formSubmission->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($formSubmission->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($formSubmission->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($formSubmission->modified) ?></td>
        </tr>
    </table> -->
    <!-- <div class="row">
        <h4><?= __('Submitted Data') ?></h4>
        <?= $this->Text->autoParagraph(h($formSubmission->submitted_data)); ?>
    </div> -->
    <div class="row" id="admin_view_submitted_data">
        <div class="col-md-12">
            <div id="build-wrap"></div>
            <?= $this->Form->hidden('submitted_data',['id'=>'tableData', 'value' => $formSubmission->submitted_data ]); ?>
        </div>
    </div>
</div>
<?=  $this->Html->script('../dist/js/jquery.min'); ?>
<?= $this->Html->script('../js/jquery-ui.min.js'); ?>
<script src="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></script> 
 <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
 <?= $this->Html->script('../js/formBuilder/form-builder-code.js'); ?>