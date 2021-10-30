<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UtilizeComoff $utilizeComoff
 */
?>
<div class="card-header" style="width: 100%; text-align: center; background-color: #E95131; margin-top: 10px; margin-bottom: 20px">
    <h2 class="m-b-0" style="color: #ffffff">Your remaining CompOff request approved hour: <?= $approvedHour;?> hours</h2>
</div>

<div class="utilizeComoffs form large-9 medium-8 columns content">
    <?= $this->Form->create($utilizeComoff) ?>
    <div class="form-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">

                    <?php
                    $options = ['class' => 'form-control',
                        'empty' => 'Select Employee',
                        'options' => $employees,
                        'default' => $employeeId,
                        'maxlength'=>100,
                        'id' => 'employee',
                        'label' => 'Employee * '
                    ];

                    //if($employeeRoleId == 4 && $is_manager == 0) {
                        $options['disabled'] = 'disabled';
                    //}

                    echo $this->Form->control('employee_id', $options);

                   // if($employeeRoleId == 4 && $is_manager == 0) {?>
                        <input type="hidden" name="employee_id" value="<?php echo $employeeId?>">
                    <?php //}
                    ?>

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">

                    <div class="form-group">
                        <div class="input text required">
                            <label class="control-label" for="dateFrom">Date From</label>
                            <input type="text" name="date" class="form-control mydatepicker" id="dateFrom" required="required" value="<?=date('m/d/Y', strtotime($utilizeComoff->date));?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php
                    echo $this->Form->control(
                        'utilize_hours', [
                            'label' => [
                                'class' => 'control-label'
                            ],
                            'class' => 'form-control',
                            'required' => 'true'
                        ]
                    );
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">

                    <div class="form-group">
                        <div class="input text required">
                            <label class="control-label" for="dateFrom">Remaining approved CompOff hours</label>
                            <input type="text" name="date" class="form-control" disabled="true" value="<?=$approvedHour;?>">
                        </div>
                    </div>
                </div>
            </div>
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
    <?= $this->Form->end() ?>
</div>
