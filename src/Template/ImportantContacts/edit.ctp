<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportantContact $importantContact
 */
?>
<div class="importantContacts form large-9 medium-8 columns content">
  <?php 
     if(!empty($importantContact)){ ?>
    <?= $this->Form->create($importantContact,['type' => 'POST','id'=>'addcontact']) ?>
    <fieldset>
        <legend><?= __('Edit Contact Information') ?></legend>
                    <div class="row" id="main-container">
                    <div class="col-md-6">
                    <div class="form-group">
                                <?php echo $this->Form->control(
                                    'name_of_contact',[
                                        'type'=>'text',
                                        'class' => 'form-control',
                                        'label' => 'Name of contact',
                                        'id'    => 'name_of_contact',
                                        'placeholder'=>' Name of the contact'
                                    ]);
                                ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                                <?php echo $this->Form->control(
                                    'contact_no',[
                                        'type'=>'text',
                                        'class' => 'form-control',
                                        'label' => 'Contact Number',
                                        'id'    => 'contact_no',
                                        'placeholder'=>'Contact Number'
                                    ]);
                                ?>
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-panel">Contact Type</label>
                            <?php
                                echo $this->Form->select(
                                    'type',[
                                        '' => 'Select',
                                        '1'=>'Mobile',
                                        '2'=>'Landline'
                                    ],['class'=>'form-control','id'=>'type']
                                );
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-panel">Role</label>
                                <?php
                                    echo $this->Form->control(
                                        'role', [
                                            'templates' => [],
                                            'required' => true,
                                            'class' => 'form-control',
                                            'options' => $roles,
                                            'maxlength'=>100,
                                            'label' =>  '',
                                            'id'=>'roles',
                                            'multiple'=>"multiple"
                                        ]
                                    );
                                ?>
                                <input type="hidden" value="<?= $importantContact['role'] ?>" id="selecetdrole" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-panel">Location</label>
                            <?php
                                echo $this->Form->control(
                                    'location', [
                                        'templates' => [],
                                        'required' => true,
                                        'class' => 'form-control dropdown-mul-1',
                                        'options' => $Locations,
                                        'maxlength'=>100,
                                        'label' =>  '',
                                        'id'=>'locations',
                                        'multiple'=>"multiple"
                                    ]
                                );
                            ?>
                            <input type="hidden" value="<?= $importantContact['location'] ?>" id="selecetdLocations" />
                        </div>
                    </div>               
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $this->Form->control(
                                'description',[
                                    'class' => 'form-control',
                                    'label' => 'Description',
                                    'id'    => 'description',
                                    'placeholder'=>'Description about contact'
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
                </fieldset>
                <?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary','id'=>'addcontact']) ?>
                <?= $this->Form->end() ?>
    <?php
    }
    ?>
</div>

