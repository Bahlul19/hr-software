<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProcessDocumentation $processDocumentation
 */
?>

<div class="processDocumentation form large-9 medium-8 columns content">
<br>
    <?= $this->Form->create($processDocumentation,['type' => 'POST','id'=>'addProcess']) ?>
    <div class="row" id="main-container">
        <div class="col-md-12">
           <div class="form-group">
                    <?php echo $this->Form->control(
                         'title',[
                             'type'=>'text',
                             'class' => 'form-control',
                             'label' => 'process documentation title',
                             'id'    => 'title',
                             'placeholder'=>' Name of the Process'
                         ]);
                    ?>
           </div>
       </div>
        <div class="col-md-6">
            <div class="form-group">
               <!-- <?php 
               //debug($allDepartment); 
               ?> -->
                <label class="control-panel">Departments</label>
                    <?php
                        echo $this->Form->control(
                            'roles', [
                                'required' => true,
                                'class' => 'form-control',
                                'options' => $allDepartment,
                                'label' =>  '',
                                'empty'=>'Select Department',
                                'id'=>'roles',
                                'multiple'=>"multiple"
                            ]
                        );
                    ?>
            </div>
            <input type="hidden" value="<?= $processDocumentation['roles'] ?>" id="selectedrole" />
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-panel">Location</label>
                <?php
                    echo $this->Form->control(
                        'office', [
                            'required' => true,
                            'class' => 'form-control',
                            'options' => $Locations,
                            'maxlength'=>100,
                            'label' =>  '',
                            'empty'=>'Select Location',
                            'id'=>'office',
                            'multiple'=>"multiple"
                        ]
                    );
                ?>
             
                <input type="hidden" value="<?= $processDocumentation['office'] ?>" id="selecetdLocations" />
            </div>
        </div>       
        <div class="col-md-12">
            <div class="form-group">
                 <?php echo $this->Form->control(
                     'description',[
                         'required'=>false,
                         'class' => 'form-control',
                         'label' => 'Description',
                         'id'    => 'processdescription',
                         'rows'  => '10',
                         'placeholder'=>'Description for the process documentation'
                     ]);
                 ?>
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group">
                <label class="control-panel">Tags</label>
                    <?php
                        echo $this->Form->control(
                            'tags', [
                                'class' => 'form-control',
                                'options' => $allTags,
                                'maxlength'=>100,
                                'label' =>  '',
                                'id'=>'tags',
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