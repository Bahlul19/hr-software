<div class="row" id="leave-request">
    <?php $is_approved = $leaveRequest['is_approved'];?>
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Edit Leave Request</h4>
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
                                                'type'=>'hidden'
                                            ]
                                        );
                                    echo $this->Form->control(
                                        'reporting_managerId', [
                                            'label' => [
                                                'class' => 'control-label'
                                            ],
                                            'class' => 'form-control',
                                            'type'=>'hidden'
                                        ]
                                    );
                                    echo $this->Form->control(
                                        'office_location', [
                                            'label' => [
                                                'class' => 'control-label'
                                            ],
                                            'class' => 'form-control',
                                            'value' => $employeeOfficeLocation,
                                            'id' => 'officeLocation',
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
                                $leaveType = array('SYL','DHK','NYC');
                                if (in_array($employeeOfficeLocation, $leaveType)) {
                                        if ($employeeType == "intern") {
                                            echo $this->Form->select(
                                                'leave_type', [
                                                '' => 'Select',
                                                '1' => 'Sick Leave'
                                            ], ['class' => 'form-control','id'=>'leaveType']
                                            );
                                        } else {
                                            echo $this->Form->select(
                                                'leave_type', [
                                                '' => 'Select',
                                                '1' => 'Sick Leave',
                                                '2' => 'Casual Leave',
                                                '3' => 'LWoP Leave',
                                                '4' => 'Earned Leave'
                                            ], ['class' => 'form-control','id'=>'leaveType']
                                            );
                                        }
                                    } elseif ($employeeOfficeLocation == "GOA") {
                                    echo $this->Form->select(
                                        'leave_type',[
                                        '' => 'Select',
                                        '3' => 'LWoP Leave',
                                        '5'=>'Un-Planned Leave',
                                        '6'=>'Planned Leave',
                                        '7'=>'Restricted holiday'
                                    ],['class'=>'form-control','id'=>'leaveType']
                                    );
                                } else {
                                    echo $this->Form->select(
                                        'leave_type',[
                                        '' => 'Select',
                                        '3' => 'LWoP Leave',
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
                                    <div class="input text required">
                                        <label class="control-label" for="dateFrom">Date From</label>
                                        <input type="text" name="date_from" class="form-control mydatepicker" id="dateFrom" required="required" <?php if($is_approved == 1) echo "disabled"; ?> value="<?=date('m/d/Y', strtotime($leaveRequest->date_from));?>">
                                        <?php if($is_approved == 1) {?>
                                            <input type="hidden" name="hidden_date_from_for_approved" value="<?=date('m/d/Y', strtotime($leaveRequest->date_from));?>">
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input text required">
                                        <label class="control-label" for="dateTo">Date To</label>
                                        <input type="text" name="date_to" class="form-control mydatepicker" id="dateTo" required="required" <?php if($is_approved == 1) echo "disabled"; ?> value="<?=date('m/d/Y', strtotime($leaveRequest->date_to));?>">
                                        <?php if($is_approved == 1) {?>
                                            <input type="hidden" name="hidden_date_to_for_approved" value="<?=date('m/d/Y', strtotime($leaveRequest->date_to));?>">
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->control(
                                            'no_of_days',[
                                                'lable' => [
                                                    'class' => 'control-label'
                                                ],
                                                'type' => 'number',
                                                'class' => 'form-control',
                                                'id' => 'noOfDays',
                                                'readonly'=>'true'
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
                                            'half_day',
                                            [
                                                '0' => 'Select',
                                                '1'=>'First Half', 
                                                '2'=>'Second Half'
                                            ],
                                            ['class'=>'form-control',
                                            'required'=>'false', 'id' => 'halfDay']
                                        );
                                    ?>
                                </div>
                            </div>  
                        </div>
                        <?php
                            $leaveType = array('SYL','DHK','NYC');
                            $leaveTypeGoa = array('GOA');
                            if (in_array($employeeOfficeLocation, $leaveType)) {
                        ?>
                        <div class="row">   
                            <div class="col-md-3">
                            <label for="">Sick Leave Taken</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('sick_leave_taken',['class' => 'form-control','id'=>'sickTaken','value'=>$sick_taken,'readonly'=>'true']);
                                    ?>
                                </div>
                            </div>      
                            <div class="col-md-3">
                            <label for="">Rem. Sick Leave</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('available_sick_leave',['class' => 'form-control','id'=>'sickRemaining','value'=>$remainingSickLeave,'readonly'=>'true']);
                                    ?>
                                </div>
                            </div>    
                            <div class="col-md-3">
                            <label for="">Casual Leave Taken</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('casual_leave_taken',['class' => 'form-control','id'=>'casualTaken','readonly'=>'true','value' => $casual_taken]);
                                    ?>
                                </div>
                            </div>    
                            <div class="col-md-3">
                            <label for="">Rem. Casual Leave</label>
                                <div class="form-group">
                                    <?php
                                    if(!empty($remainingCasualLeave)){
                                        echo $this->form->text('available_casual_leave',['class' => 'form-control','id'=>'casualRemaining','readonly'=>'true','value'=>$remainingCasualLeave]);
                                    } else {
                                        echo $this->form->text('available_casual_leave',['class' => 'form-control','readonly'=>'true','value'=>'Not Applicable']);
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
                                    echo $this->form->text('lwop_leave_taken',['class' => 'form-control','id'=>'earnedTaken','readonly'=>'true','value' => $earned_taken]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Rem. Earned Leave</label>
                                <div class="form-group">
                                    <?php
                                    echo $this->form->text('lwop_leave_taken',['class' => 'form-control','id'=>'earnedRemaining','readonly'=>'true','value' => $remainingEarnedLeave]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <label for="">LWoP Leave Taken</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('lwop_leave_taken',['class' => 'form-control','id'=>'lwopTaken','readonly'=>'true','value' => $LWoP_taken]);
                                    ?>
                                </div>
                            </div>    
                            <div class="col-md-3">
                            <label for="">Total Leave Taken</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('available_lwop_leave',['class' => 'form-control','readonly'=>'true','value' => $totalLeaveTaken]);
                                    ?>
                                </div>
                            </div>                                      
                        </div>
                    <?php } elseif (in_array($employeeOfficeLocation, $leaveTypeGoa)) {?>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Planned Leave Taken</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('earned_leave_taken',['class' => 'form-control','id'=>'plannedTaken','readonly'=>'true','value' => $planned_taken]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Rem. Planned Leave</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('available_earned_leave',['class' => 'form-control','id'=>'plannedRemaining','readonly'=>'true','value' => $remainingPlannedLeave]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Un-Planned Leave Taken</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('lwop_leave_taken',['class' => 'form-control','id'=>'unplannedTaken','readonly'=>'true','value' => $unplanned_taken]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Rem. Un-Planned Leave&nbsp;&nbsp;&nbsp;   </label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('available_lwop_leave',['class' => 'form-control','id'=>'unplannedRemaining','readonly'=>'true','value' => $remainingUnplannedLeave]);
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
                                <div class="col-md-3">
                                <label for="">LWoP Leave Taken</label>
                                    <div class="form-group">
                                        <?php
                                            echo $this->form->text('lwop_leave_taken',['class' => 'form-control','readonly'=>'true','id'=>'lwopTaken','value' => $LWoP_taken]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Total Leave Taken</label>
                                    <div class="form-group">
                                        <?php
                                        echo $this->form->text('available_lwop_leave', ['class' => 'form-control', 'readonly'=>'true','value'=>$totalLeaveTakenForGoa]);
                                        ?>
                                    </div>
                                </div>
                            </div>

                    <?php } else {?>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Leave Taken</label>
                                <div class="form-group">
                                    <?php
                                    echo $this->form->text('', ['class' => 'form-control', 'id'=>'dayOffTaken', 'readonly'=>'true','value'=>$dayOffTaken]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <label for="">LWoP Leave Taken</label>
                                <div class="form-group">
                                    <?php
                                        echo $this->form->text('lwop_leave_taken',['class' => 'form-control','readonly'=>'true','value' => $LWoP_taken]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Remaining Leave</label>
                                <div class="form-group">
                                    <?php
                                    echo $this->form->text('', ['class' => 'form-control', 'id'=>'dayOffRemaining', 'readonly'=>'true','value'=>$remainingDayOff]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                      <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php

                                        $options = [
                                            'label' => [
                                                'class' => 'control-label'
                                            ],
                                            'type' => 'textarea',
                                            'class'=> 'form-control'
                                        ];

                                        if($is_approved == 1) {
                                            $options['disabled'] = "disabled";
                                        }

                                        echo $this->Form->control(
                                            'leave_reason', $options
                                        );
                                    ?>

                                    <?php if($is_approved == 1) {?>
                                            <input type="hidden" name="hidden_leave_reason_for_approved" value="<?=$leaveRequest->leave_reason;?>">
                                        <?php }?>
                                </div>
                            </div>

                              <div class="col-md-6">
                                  <div class="form-group">
                                      <div class="input text required">
                                          <label class="control-label" for="reliever">Reliever <span style="color: red; font-weight: bold; font-size: 15px;">*</span></label>
                                          <br/>
                                          <!-- <input type="text" name="reliever" class="form-control" required="required" maxlength="100" id="reliever" placeholder="Reliever"> -->
                                          <select required name="list[]" data-placeholder="Choose a Reliever..." class="chosen-select" multiple tabindex="4" style="width: 100%!important; font-size: 18px">
                                              <?php
                                              foreach ($reliever as $key=>$value):?>
                                                  <option <?= in_array($key, $previousSelectedRelieverList) ? "selected" : ""?> name="check_list[]" value="<?php echo $key?>" style="font-size: 16px;"><?php echo $value?></option>
                                              <?php endforeach?>
                                          </select>
                                      </div>
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
