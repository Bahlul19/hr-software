<!-- <?//= $employeeDesignationId; ?> -->
 <div class="row" id="leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Add Leave Request</h4>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create($leaveRequest) ?>   
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'employee_name', [
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'class' => 'form-control',
                                                'value' => $employeeName,
                                                'readonly'=>'true'
                                            ]
                                        );

                                    ?>
                                    <?php
                                        echo $this->Form->control(
                                            'employee_id', [
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'class' => 'form-control',
                                                'value' => $employeeId,
                                                'type'=>'hidden'
                                            ]
                                        );
                                    echo $this->Form->control(
                                        'reporting_managerId', [
                                            'label' => [
                                                'class' => 'control-label'
                                            ],
                                            'class' => 'form-control',
                                            'value' => $employeeReportingManager,
                                            'type'=>'hidden'
                                        ]
                                    );
                                        
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="control-panel">Leave Type</label>
                                    <?php
                                        if($employeeOfficeLocation == "SYL" || $employeeOfficeLocation == "DHK" || $employeeOfficeLocation == "NYC"){
                                            if ($employeeType == "intern"){
                                                echo $this->Form->select(
                                                    'leave_type',[
                                                        '' => 'Select',
                                                        '1'=>'Sick Leave'
                                                    ],['class'=>'form-control','id'=>'leaveType']
                                                );
                                            } else {
                                                   echo $this->Form->select(
                                                    'leave_type',[
                                                        '' => 'Select',
                                                        '1'=>'Sick Leave',
                                                        '2'=>'Casual Leave',
                                                        '3'=>'LWoP Leave',
                                                        '4'=>'Earned Leave'
                                                    ],['class'=>'form-control','id'=>'leaveType']
                                                );
                                            }
                                        } elseif ($employeeOfficeLocation == "GOA") {
                                            echo $this->Form->select(
                                                'leave_type',[
                                                '' => 'Select',
                                                '5'=>'Un-Planned Leave',
                                                '6'=>'Planned Leave',
                                                '7'=>'Restricted Holiday'
                                            ],['class'=>'form-control','id'=>'leaveType']
                                            );
                                        } else {
                                            echo $this->Form->select(
                                                'leave_type',[
                                                '' => 'Select',
                                                '8'=>'Day Off / vacation'
                                            ],['class'=>'form-control','id'=>'leaveType']
                                            );
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'date_from', [
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'type' => 'text',
                                                'class' => 'form-control mydatepicker',
                                                'id' => 'dateFrom',
                                                'autocomplete' => 'off'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'date_to',[
                                                'label' =>[
                                                    'class' => 'control-label'
                                                ],
                                                'type' => 'text',
                                                'class' => 'form-control mydatepicker',
                                                'id' => 'dateTo',
                                                'autocomplete' => 'off'
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
                                            'no_of_days',[
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'type' => 'text',
                                                'class' => 'form-control',
                                                'id' => 'noOfDays',
                                                'readonly' => 'true'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Half Day</label>
                                    <?php
                                        echo $this->Form->select(
                                            'half_day',[
                                                '' => 'Select',
                                                '1'=>'First Half', 
                                                '2'=>'Second Half'
                                            ],['class'=>'form-control',
                                            'required'=>'false', 'id' => 'halfDay']             
                                        );
                                    ?>
                                </div>
                            </div>  
                        </div>
                        <?php if($employeeOfficeLocation == "SYL" || $employeeOfficeLocation == "DHK" || $employeeOfficeLocation == "NYC"){ ?>
                        <div class="row">   
                            <div class="col-md-3">
                            <label for="">Sick Leave Taken &nbsp;&nbsp;&nbsp;</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('',['class' => 'form-control','id'=>'sickTaken','value'=>$sick_taken,'readonly'=>'true']);
                                    ?>
                                </div>
                            </div>      
                            <div class="col-md-3">
                            <label for="">Rem. Sick Leave&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('',['class' => 'form-control','id'=>'sickRemaining','placeholder'=>$remainingSickLeave,'readonly'=>'true']);
                                    ?>
                                </div>
                            </div>    
                            <div class="col-md-3">
                            <label for="">Casual Leave Taken</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('',['class' => 'form-control','id'=>'casualTaken','readonly'=>'true','placeholder' => $casual_taken]);
                                    ?>
                                </div>
                            </div>    
                            <div class="col-md-3">
                            <label for="">Rem. Casual Leave</label>
                                <div class="form-group">
                                    <?php
                                    if(!empty($remainingCasualLeave)){
                                        echo $this->form->text('',['class' => 'form-control','id'=>'casualRemaining','readonly'=>'true','placeholder'=>$remainingCasualLeave]);
                                    } else {
                                        echo $this->form->text('',['class' => 'form-control','readonly'=>'true','placeholder'=>'Not Applicable']);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Earned Leave Taken</label>
                                <div class="form-group">
                                    <?php
                                    echo $this->form->text('',['class' => 'form-control','id'=>'earnedTaken','readonly'=>'true','placeholder' => $earned_taken]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Rem. Earned Leave</label>
                                <div class="form-group">
                                    <?php
                                    echo $this->form->text('',['class' => 'form-control','id'=>'earnedRemaining','readonly'=>'true','placeholder' => $remainingEarnedLeave]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <label for="">LWoP Leave Taken</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('',['class' => 'form-control','readonly'=>'true','placeholder' => $LWoP_taken]);
                                    ?>
                                </div>
                            </div>    
                            <div class="col-md-3">
                            <label for="">Total Leave Taken&nbsp;&nbsp;&nbsp;   </label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('',['class' => 'form-control','readonly'=>'true','placeholder' => $totalLeaveTaken]);
                                    ?>
                                </div>
                            </div>                                      
                        </div>
                        <?php } elseif ($employeeOfficeLocation == "GOA") { ?>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Planned Leave Taken</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('',['class' => 'form-control','id'=>'plannedTaken','readonly'=>'true','value' => $planned_taken]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Rem. Planned Leave</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('',['class' => 'form-control','id'=>'plannedRemaining','readonly'=>'true','value' => $remainingPlannedLeave]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Un-Planned Leave Taken</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('',['class' => 'form-control','id'=>'unplannedTaken','readonly'=>'true','value' => $unplanned_taken]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Rem. Un-Planned Leave&nbsp;&nbsp;&nbsp;   </label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('',['class' => 'form-control','id'=>'unplannedRemaining','readonly'=>'true','value' => $remainingUnplannedLeave]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Restricted Holiday Taken</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('',['class' => 'form-control','id'=>'restrictedTaken','readonly'=>'true','value' => $restricted_taken]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Rem. Restricted H. Leave&nbsp;&nbsp;&nbsp;   </label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('',['class' => 'form-control','id'=>'restrictedRemaining','readonly'=>'true','value' => $remainingRestrictedLeave]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Total Leave Taken</label>
                                    <div class="form-group">
                                        <?php
                                            echo $this->form->text('', ['class' => 'form-control', 'readonly'=>'true','placeholder'=>$totalLeaveTakenForGoa]);
                                        ?>
                                    </div>
                                </div>
                            </div>

                    <?php    } else {?>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Leave Taken</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('', ['class' => 'form-control', 'id'=>'dayOffTaken', 'readonly'=>'true','value'=>$dayOffTaken]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Remaining Leave</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('', ['class' => 'form-control', 'id'=>'dayOffRemaining', 'readonly'=>'true','value'=>$remainingDayOffLeave]);
                                        ?>
                                    </div>
                                </div>
                            </div>

                    <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'leave_reason',[
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'type' => 'textarea',
                                                'class'=> 'form-control'
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input text required">
                                        <label class="control-label" for="reliever">Reliever <span style="color: red; font-weight: bold; font-size: 15px;">*</span></label>
                                        <input type="text" name="reliever" class="form-control" required="required" maxlength="100" id="reliever" placeholder="Reliever">
                                    </div>
                                    <?php
                                        // echo $this->Form->control(
                                        //     'reliever',[
                                        //         'label' => [
                                        //             'class' => 'control-label'
                                        //         ],
                                        //         'type' => 'text',
                                        //         'class'=> 'form-control'
                                        //     ]
                                        // );
                                    ?>
                                </div>
                            </div>
                        </div>    
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
                <?php echo $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Please Enter a Valid Date. "Date to" cannot be Earlier then "Date From". </p>
            </div>
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--            </div>-->
        </div>

    </div>
</div>

<div class="modal fade" id="myRemainingModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Your Leave request day(s) is/are greater then the remaining leave days. Please add a valid request or else your request will be rejected. Thank you.</p>
            </div>
        </div>

    </div>
</div>