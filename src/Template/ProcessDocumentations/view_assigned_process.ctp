<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProcessDocumentation $processDocumentation
 */
?>
<div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Process Documentation</h4>
            </div>
            <div class="card-body">
            <?= $this->Form->create($assignedProcesses,['type' => 'POST','id'=>'view_assigned_process']) ?>
            <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                           <input type='hidden' name='id' value='<?= $assignedProcesses->id ?>' />
                            <fieldset>
                                <legend> <?= $processDocumentation->title ?></legend>
                                <?= $processDocumentation->description ?>
                            <fieldset>
                        </div>
                    </div>
                    <div class="col-md-6"><br><br><br><br>
                        <div class="form-group">
                                    <?php  echo $this->Form->control(
                                            'status', [
                                                'class' => 'form-control',
                                                'empty'=>'select status',
                                                'options' => $status,
                                                'maxlength'=>100,
                                               
                                                'label' =>  '',
                                                'id'=>'status',
                                            ]
                                        );
                                    ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary','id'=>'processsubmit']) ?>
                <?= $this->Form->end() ?>
                </div>
            </div>
            
        </div>
    </div>

 
