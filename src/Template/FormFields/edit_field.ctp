<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormField $formField
 */
?>
<div id="results"></div>
<div class="formFields form large-9 medium-8 columns content">
    <button id="setData" class="btn btn-success" style="margin:10px;">Get Existing Fields</button>
    <span class="text-danger">Kindly click on the button to get existing fields or those will be lost while adding new</span>
    <?= $this->Form->create($formField,['id' => 'edit-fields-form', "enctype" => "multipart/form-data", 'action' => '#']) ?>
    <fieldset>
        <legend><?= __('Edit Form Field') ?></legend>
        <?= $this->Form->control('formField.id'); ?>

        <?= $this->Form->hidden('id', ['id'=>'customid']); ?>
        <?php
            //echo $this->Form->control('form_id', ['options' => $forms]);
            //echo $this->Form->control('field_data');
        ?>
    </fieldset>
    <?= $this->Form->control('formField.field_data',['id'=>'tableData','type'=>'hidden']); ?>
    <div id="build-wrap"></div>
    <div class="render-wrap" ></div>
    <!-- <?= $this->Form->button(__('Submit')) ?> -->
    <?= $this->Form->end() ?>
</div>

<div class="modal" tabindex="-1" id="form-create-success" role="dialog">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span> 
        </button> -->
      </div>
      <div class="modal-body">
        <p id="message"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"><a href="/forms/index">Close</a></button>
      </div>
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