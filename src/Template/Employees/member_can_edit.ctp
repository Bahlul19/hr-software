<div class="row employees" id="validation">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><?php echo _("Edit Employee"); ?></h4>
                </div>
                <div class="card-body wizard-content">
                    <?php echo $this->Form->create($employee, ['type' => 'file','class' => 'validation-wizard wizard-circle']); ?>
                        
                        <section>
                            
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('personal_email', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Personal Email',
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('mobile_number', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Mobile Number',
                                            ]); 
                                        ?>
                                    </div>
                                </div>            
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('permanent_address', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Permanent Address',
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('present_address', ['class' => 'form-control']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('emergency_number', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Emergency Number *',
                                                'required' => 'true'
                                            ]); 
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        
                                        <?php
                                            echo $this->Form->control('birth_date', [
                                                'class' => 'form-control mydatepicker',
                                                'type' => 'text',
                                                'value' => date('m/d/Y', strtotime($employee->birth_date))
                                            ]);
                                        ?>
                                    
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <?php
                                            echo $this->Form->control('blood_group', [
                                                'class' => 'form-control',
                                                'options' => [
                                                    'A'=>'A',
                                                    'A+ve'=>'A +ve',
                                                    'A-ve'=>'A -ve',
                                                    'B+ve'=>'B +ve',
                                                    'B-ve'=>'B -ve',
                                                    'AB+ve'=>'AB +ve',
                                                    'AB-ve'=>'AB -ve',
                                                    'O+ve'=>'O +ve',
                                                    'O-ve'=>'O -ve',
                                                    '' => 'Select Blood Group'
                                                ],
                                                'disabled' => [''],
                                                'value' => (isset($employee->blood_group)) ? $employee->blood_group :  ['']
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            echo $this->Form->control('languages', [
                                                'class' => 'form-control'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $this->Form->control('max_qualification', 
                                            [
                                                'class' => 'form-control',
                                                'label' => 'Max Qualification'
                                            ]); 
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">
                                            Profile Picture
                                        </label>
                                        <?php
                                            echo $this->Form->file('profile_pic', [
                                                'class' => 'form-control',
                                                'label' => 'Profile Picture'
                                            ]);
                                        ?>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    
                                </div>

                                <div class="col-md-6">
                                    <div class="form-actions">
                                    <?php
                                        echo $this->Form->button(__('Submit'), ['type' => 'submit','class' => 'btn btn-info mr-1']);

                                        echo $this->Html->link(
                                            __('Back'),
                                            ['action' => 'index'], ['class' => 'btn btn-inverse']
                                        );
                                    ?>
                                    </div>
                                </div>
                            </div>

                        </section>
                         <?php echo $this->Form->end() ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
