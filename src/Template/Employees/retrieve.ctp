<?php echo $this->Form->create($employee, ['class'=>'form p-t-20']); ?>
<a href="javascript:void(0)" class="text-center db">
    <img src="/../img/logo/sj-connect-logo.png" alt="Home" />
</a>
    <div class="form-horizontal form-material">
        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <?php
                    echo $this->Form->control(
                        'password', [
                            'class' => 'form-control',
                            'placeholder' => 'Password',
                            'label' => false,
                            'type' => 'password',
                            'autofocus',
                            'autocomplete' => 'off',
                            'required',
                            'minlength' => 8
                        ]
                    );
                ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-xs-12">
                <?php
                    echo $this->Form->control(
                        'repeat', [
                            'class' => 'form-control',
                            'placeholder' => 'Repeat',
                            'label' => false,
                            'type' => 'password',
                            'autocomplete' => 'off',
                            'required',
                            'minlength' => 8
                        ]
                    );
                ?>
            </div>
        </div>
    </div>
    <?php
        echo $this->Form->control(
            'office_email', [
                'label' => false,
                'type' => 'hidden',
                'value' => $office_email
            ]
        );
    ?>
    <?php
        echo $this->Form->control(
            'userId', [
                'label' => false,
                'type' => 'hidden',
                'value' => $userId
            ]
        );
    ?>
    <?php
        echo $this->Form->control(
            'token', [
                'label' => false,
                'type' => 'hidden',
                'value' => $token
            ]
        );
    ?>
    <?php
        echo $this->Form->button(
            __('Change Password'),[
                'class' => 'btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light'
            ]
        )
    ?>
<?php echo $this->Form->end(); ?>