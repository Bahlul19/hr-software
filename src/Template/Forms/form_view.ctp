<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormField $formField
 */
?>
<div id="results"></div>
<div class="formFields form large-9 medium-8 columns content">
    <?= $this->Form->create('form-view',['id' => 'form-view', "enctype" => "multipart/form-data", 'action' => '','onSubmit'=>'return false;']) ?>
    <fieldset>
        <legend><?= __($formField['title']) ?></legend>
        <p><?= __($formField['description']) ?></p>

        <?= $this->Form->hidden('form_id',['custom'=>'tableData', 'value' => $formField['id'] ]); ?>
    </fieldset>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= $this->Form->control('feedback_for', [
                        'options' => $employees,
                        'empty'=>['0'=>'Select Employee'],
                        'label' => [
                            'class' => 'control-label'
                        ],
                        'class' => 'form-control',
                        'hidden'=>['0'],
                    ]); ?>
            </div>
        </div>
    </div>
    <div id="build-wrap"></div>
    <div class="render-wrap"></div>
    <?php 
    if(!empty($formField['form_field'])){
         $formFieldData=$formField['form_field']['field_data'];
    }else{
        $formFieldData="";
    }  
    ?>
    <?= $this->Form->hidden('field_data',['id'=>'tableData', 'value' =>$formFieldData]); ?>
    <?= $this->Form->hidden('form_submission_data',['id'=>'submitted_data', 'value' => '' ]); ?>
    <?= $this->Form->end() ?>
</div>

<div class="modal" tabindex="-1" id="form-loader" role="dialog">
   <div style="text-align:center;margin-top:110px;">
     <img src="/webroot/img/ajaxloader.gif" style="width:100px;" />
   </div>
</div>

<div class="modal" tabindex="-1" id="form-submission-success" role="dialog">
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
        <button type="button" class="btn btn-secondary"><a href="/form-submissions/index">Close</a></button>
      </div>
    </div>
  </div>
</div>
<?=  $this->Html->script('../dist/js/jquery.min'); ?>
<script src="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></script> 
 <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
 <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
 <?= $this->Html->script('../js/formBuilder/form-builder-code.js'); ?>