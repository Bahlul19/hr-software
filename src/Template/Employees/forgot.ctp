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
                            'placeholder' => 'Email',
                            'label' => false,
                            'type' => 'email',
                            'autofocus',
                            'autocomplete' => 'off',
                            'required'
                        ]
                    );
                ?>
            </div>
        </div>
    </div>
    <?php
        echo $this->Form->button(
            __('Retrieve'),[
                'class' => 'btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light'
            ]
        )
    ?>
<?php echo $this->Form->end(); ?>