<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProcessDocumentation $processDocumentation
 */
?>

<div class="AssignProcesses form large-9 medium-8 columns content">
<br>
    <div id='loader' style="display:none;width: 75vw;height: 20vw;position: absolute;z-index: 100;text-align: center;line-height: 18px;">     
        <?= $this->Html->image('spinner.gif',['style'=>"width: 100px;height: 100px;margin-top: 70px;"]); ?>
    </div>
    <?= $this->Form->create($AssignProcesses,['type' => 'POST','id'=>'AssignProcesses']) ?>
    <div class="row" id="main-container">
    <div class="col-md-6">
           <div class="form-group">
                    <?php echo $this->Form->control(
                            'office', [
                                'class' => 'form-control',
                                'options' => $allOffices,
                                'id'=>'offices',
                                'empty'=>'Select Office'
                            ]
                        );
                    ?>
           </div>
       </div>
        <div class="col-md-6">
           <div class="form-group">
                    <?php echo $this->Form->control(
                            'employee_id', [
                                'class' => 'form-control',
                                'options' => $allEmployees,
                                'id'=>'employee_id',
                                'empty'=>'Select employee'
                            ]
                        );
                    ?>
           </div>
       </div>
       <div class="col-md-12">
           <div class="form-group">
                    <?php  echo $this->Form->control(
                            'process_id', [
                                'class' => 'form-control',
                                'options' => '',
                                'maxlength'=>100,
                                'label' =>  'Assign Processes',
                                'id'=>'process_id',
                                'multiple'=>"multiple"
                            ]
                        );
                    ?>
           </div>
       </div>
    </div>
    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary','id'=>'processsubmit']) ?>
    <?= $this->Form->end() ?>
<?php 
?>

