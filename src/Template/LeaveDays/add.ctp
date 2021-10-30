<!-- New Design for Adding Leave Days -->
<div class="row designation">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add Leave Days for <?= $employeeName?></h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($leaveDay) ?>
                <div class="form-body">
                <?php if($officeLocation == "SYL" || $officeLocation == "DHK"  || $officeLocation == "NYC" ) {?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                    echo $this->Form->control('sick_leave', [
                                            'label' => [
                                                'class' => 'control-label'
                                            ],
                                            'class'=>'form-control',
                                            'id'=>'sick-leave'
                                        ]
                                    );
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                    echo $this->Form->control('casual_leave', [
                                            'label' => [
                                                'class' => 'control-label'
                                            ],
                                            'class'=>'form-control',
                                            'id'=>'casual-leave'
                                        ]
                                    );
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control('earned_leave', [
                                        'label' => [
                                            'class' => 'control-label'
                                        ],
                                        'class'=>'form-control',
                                        'id'=>'earned-leave'
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                    </div>
        <?php
            } else if ($officeLocation == "GOA") {
        ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control('planned_leave', [
                                        'label' => [
                                            'class' => 'control-label'
                                        ],
                                        'class'=>'form-control',
                                        'id'=>'planned-leave'
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control('unplanned_leave', [
                                        'label' => [
                                            'class' => 'control-label'
                                        ],
                                        'class'=>'form-control',
                                        'id'=>'unplanned-leave'
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control('restricted_leave', [
                                        'label' => [
                                            'class' => 'control-label'
                                        ],
                                        'class'=>'form-control',
                                        'id'=>'restricted-leave'
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php } else { ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                echo $this->Form->control('day_off', [
                                        'label' => [
                                            'class' => 'control-label'
                                        ],
                                        'class'=>'form-control',
                                        'id'=>'day-off'
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php   }    ?>
                    <?php
                        echo $this->Form->text('created_by', [
                                'label' => [
                                    'class' => 'control-label'
                                ],
                                'class'=>'form-control',
                                'value'=>$createdBy,
                                'hidden'=>'true'
                            ]
                        );
                        echo $this->Form->text('employee_id', [
                                'label' => [
                                    'class' => 'control-label'
                                ],
                                'class'=>'form-control',
                                'value'=>$employeeId,
                                'hidden'=>'true'
                            ]
                        );
                    ?>
                </div>

                <div class="form-actions">
                    <?php
                    echo $this->Form->button(__('Submit'), ['class' => 'btn btn-info']);

                    echo $this->Html->link(
                        __('Back'),
                        ['controller'=>'employees','action' => 'index'], ['class' => 'btn btn-inverse']
                    );
                    ?>
                </div>
                <?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>