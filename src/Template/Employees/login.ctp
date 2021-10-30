<?php echo $this->Form->create($employee, ['class'=>'form p-t-20']); ?>
<a href="javascript:void(0)" class="text-center db">
    <img src="/../img/logo/sj-connect-logo.png" alt="Home" />
</a>
    <div class="form-horizontal form-material">
        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <?php
                    echo $this->Form->control(
                        'office_email', [
                            'class' => 'form-control',
                            'placeholder' => 'username',
                            'label' => false,
                            'type' => 'email'
                        ]
                    );
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <?php
                    echo $this->Form->control(
                        'password', [
                            'class' => 'form-control',
                            'placeholder' => 'Password',
                            'label' => false,
                            'type' => 'password'
                        ]
                    );
                ?>
            </div>
        </div>
    </div>
    <?php
        echo $this->Form->button(
            __('Login'),[
                'class' => 'btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light'
            ]
        )
    ?>
<?php echo $this->Form->end(); ?>
<div class="card-body text-center">
<?php
echo $this->Html->link(
    'FORGOT PASSWORD',
    '/employees/forgot',
    ['class' => '']
);
?>
</div>