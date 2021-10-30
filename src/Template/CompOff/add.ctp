<!-- <?//= $employeeDesignationId; ?> -->
<div class="row" id="leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add CompOff Request</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create('compOff');
                ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  
                                    <?php
                                        echo $this->Form->control(
                                            'name', [
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'class' => 'form-control',
                                                'default' => $employeeId,
                                                'value' => $employeeName,
                                                'id' => 'employee',
                                                'readonly'=>'true',
                                                'required' => ''
                                            ]
                                        );

                                        if ($employeeRoleId == 4 && $is_manager == 0) {
                                            $options['disabled'] = 'disabled';
                                        }

                                         //if($employeeRoleId == 4 && $is_manager == 0) {?>
                                                <input type="hidden" name="employee_id" value="<?php echo $employeeId?>">
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
                                                    'placeholder'=>"Enter Date",
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
                                                'required' => 'true',
                                                'placeholder'=>"Enter Number Of Hours e.g 1.5, 2, 3.2",
                                                'min' => 0.2
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
                                                'pattern' => '[a-zA-Z ]{1,}',
                                                'placeholder'=>"Enter Team Name",
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
                                                 'pattern' => '[a-zA-Z ]{1,}',
                                                 'placeholder'=>"Enter Name Of The Project",
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
                                              'placeholder'=>"Enter Task Details",
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
