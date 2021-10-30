<!-- <?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary $salary
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Salary'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav> -->
<!-- New Design for salary -->
<div class="row designation">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add Salary</h4>
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
                                                'value'=>$employee->id,
                                                'hidden'=>'true'
                                            ]
                                        );
                                        echo $this->Form->control('employee_name', [
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'class'=>'form-control',
                                                'value'=>$employee->first_name.' '.$employee->last_name,
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
                                            'options' => $designations
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
                                                'value'=>$employee->salary_amount,
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
                                    ?>
                                </div>
                            </div>    
                        </div>
                    </div>
                      <div class="form-actions">
                            <?php
                                echo $this->Form->button(__('Submit'), ['class' => 'btn btn-info']);

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
