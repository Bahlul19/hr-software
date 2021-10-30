 <?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary $salary
 */
?>
<div class="row designation">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Edit Salary</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($salary) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->text('employee_id', [
                                            'label' => [
                                                'class' => 'control-label'
                                            ],
                                            'class'=>'form-control',
                                            'value'=>$salary->employee_id,
                                            'hidden'=>'true'
                                        ]
                                    );
                                    echo $this->Form->control('employee_name', [
                                            'label' => [
                                                'class' => 'control-label'
                                            ],
                                            'class'=>'form-control',
                                            'value'=>$salary->employee_name,
                                            'readonly'=>'true'
                                        ]
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->control('designation_id', [
                                            'class' => 'form-control',
                                            'empty' => 'Select Designation',
                                            'options' => $designations,
                                            'value'=> $selectedDesignation
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
                                            'salary_amount', [
                                                'label' => [
                                                        'class' => 'control-label'
                                                    ],
                                                'class' => 'form-control'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'reason', [
                                                'label' => [
                                                        'class' => 'control-label'
                                                    ],
                                                'class' => 'form-control',
                                                'options'=> [
                                                    'New Entry' => 'New Entry',
                                                    'Promotion' => 'Promotion',
                                                    'Increment' => 'Increment',
                                                ]
                                            ]
                                        );
                                        echo $this->Form->text(
                                            'updated_by', [
                                                'label' => [
                                                        'class' => 'control-label'
                                                    ],
                                                'class' => 'form-control',
                                                'value' => $employeeName,
                                                'hidden' => 'true'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>    
                        </div>
                    </div>
                      <div class="form-actions">
                            <?php
                                echo $this->Form->button(__('Update'), ['class' => 'btn btn-info']);

                                echo $this->Html->link(
                                    __('Back'),
                                    ['action' => 'index'], ['class' => 'btn btn-inverse']
                                );
                            ?>
                      </div>
                <?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
