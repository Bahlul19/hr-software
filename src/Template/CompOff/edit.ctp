<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompOff $compOff
 */
?>
<div class="row" id="leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Edit CompOff Request</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($compOff) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">

                                <?php
                                $options = ['class' => 'form-control',
                                    'empty' => 'Select Employee',
                                    'options' => $employees,
                                    'maxlength'=>100,
                                    'id' => 'employee',
                                    'label' => 'Employee * '
                                ];

                                //if($employeeRoleId == 4) {
                                    $options['disabled'] = 'disabled';
                                //}

                                echo $this->Form->control('employee_id', $options);

                                //if($employeeRoleId == 4) {?>
                                    <input type="hidden" name="employee_id" value="<?php echo $compOffEmployeeId?>">
                                <?php //}
                                ?>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control(
                                    'date', [
                                        'label' => [
                                            'class' => 'control-label'
                                        ],
                                        'type' => 'text',
                                        'class' => 'form-control mydatepicker',
                                        'id' => 'date',
                                        'autocomplete' => 'off',
                                        'required' => 'true'
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control(
                                    'number_of_hours', [
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
                                <?php
                                $options = ['class' => 'form-control',
                                    'empty' => 'Select Project Manager',
                                    'options' => $employees,
                                    'maxlength'=>100,
                                    'id' => 'employee',
                                    'label' => 'Project Manager * ',
                                    'required' => 'true'
                                ];

                                echo $this->Form->control('pm_id', $options);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control(
                                    'team_name', [
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
                                <?php
                                echo $this->Form->control(
                                    'name_of_the_project', [
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


                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <?php
                                echo $this->Form->control(
                                    'project_task_details', [
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
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

