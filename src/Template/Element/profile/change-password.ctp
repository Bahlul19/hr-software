<div class="card">
    <div class="card-header" id="change-password" role="tab" data-toggle="collapse" href="#change-password-data" aria-expanded="true" aria-controls="change-password-data">
        <h5 class="mb-0 text-white">
            Change Password
        </h5>
    </div>
    <div id="change-password-data" class="collapse" role="tabpanel" aria-labelledby="change-password" data-parent="#accordion">
        <div class="card-body">
            <?php echo $this->Form->create($employee,['action' => 'change-password'],['type' => 'POST']);?>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                            <?php 
                                echo $this->Form->control('old_password', 
                                    [
                                        'class' => 'form-control',
                                        'label' => 'Password *',
                                        'type'  => 'password',
                                        'required' => true
                                    ]
                                ); 
                            ?>
                        
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                            <?php 
                                echo $this->Form->control('new_password', 
                                    [
                                        'class' => 'form-control',
                                        'label' => 'New Password *',
                                        'type'  => 'password',
                                        'required' => true
                                    ]
                                ); 
                            ?>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                            <?php 
                                echo $this->Form->control('confirm_password', 
                                    [
                                        'class' => 'form-control',
                                        'label' => 'Confirm Password *',
                                        'type'  => 'password',
                                        'required' => true
                                    ]
                                ); 
                            ?>
                        
                    </div>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo $this->Form->submit('Change Password',['class' => 'btn btn-info']); ?>
                    </div>
                </div>
            </div>
            <?php $this->Form->end();?>
        </div>
    </div>
</div>
