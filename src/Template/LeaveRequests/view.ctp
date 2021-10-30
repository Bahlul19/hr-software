<div class="row leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">View Leave Request</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Name :</label>
                            <?= $leaveRequest->has('employee') ? $this->Html->link($leaveRequest->employee->first_name. ' '.$leaveRequest->employee->last_name, ['controller' => 'Employees', 'action' => 'view', $leaveRequest->employee->id]) : '' ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Leave Type: </label>
                            <?php
                            if($leaveRequest->leave_type == 1){
                                $leaveType = "Sick Leave";
                            } elseif($leaveRequest->leave_type == 2){
                                $leaveType = "Casual Leave";
                            } elseif(h($leaveRequest->leave_type) == 3){
                                $leaveType="LWoP Leave";
                            }  elseif(h($leaveRequest->leave_type) == 5){
                                $leaveType="Un-Planned Leave";
                            }  elseif(h($leaveRequest->leave_type) == 6){
                                $leaveType="Planned Leave";
                            } elseif(h($leaveRequest->leave_type) == 7){
                                $leaveType="Restricted Leave";
                            }  elseif(h($leaveRequest->leave_type) == 8){
                                $leaveType="Day Off";
                            } else {
                                $leaveType = "Earned Leave";
                            }
                            echo $leaveType;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Date From: </label>
                            <?php
                            echo date('m/d/Y',strtotime(h($leaveRequest->date_from)));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Date To: </label>
                            <?php
                            echo date('m/d/Y',strtotime(h($leaveRequest->date_to)));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">No. of Days: </label>
                            <?php 
                            if ($leaveRequest->half_day == 1 || $leaveRequest->half_day == 2){ 
                                //echo "0.5"; If and else not required here, We can remove this if issue is resolved in live.
                                echo h($leaveRequest->no_of_days);
                             } else { 
                                echo h($leaveRequest->no_of_days);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Half Day: </label>
                            <?php
                            if($leaveRequest->half_day == 1){
                                $halfDay = "Before Lunch";
                            }
                            elseif($leaveRequest->half_day == 2){
                                $halfDay = "Post Lunch";
                            }
                            else {
                                $halfDay = " ";
                            }
                            echo $halfDay;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Leave Reason: </label>
                            <?php
                            echo h($leaveRequest->leave_reason);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Reliever: </label>
                            <?php
                                echo h($leaveRequest->reliever);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Created: </label>
                            <?php
                            h($leaveRequest->created);
                            echo date('m/d/Y',strtotime(h($leaveRequest->created)));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Modified: </label>
                            <?php
                            h($leaveRequest->modified);
                            echo date('m/d/Y',strtotime(h($leaveRequest->modified)));
                            ?>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                <?php
                $role = array(1,2);
                if((in_array($loggedUser['role_id'], $role)) && $leaveRequest->is_approved != 0){
                ?>
                    <div class="col-md-6">
                        <div class="form-group">
                        <?php if ($leaveRequest->is_approved == 1): ?>
                            <label class="control-label">Approved by: </label>
                            <?php
                                echo h($leaveRequest->approved_by)
                            ?>
                        <?php endif; ?>
                        <?php if($leaveRequest->is_approved == 2): ?>
                            <label class="control-label">Rejected by: </label>
                            <?php
                                echo h($leaveRequest->approved_by)
                            ?>
                        <?php endif; ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if($leaveRequest->is_approved == 2): ?>            
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Reject Reason: </label>
                            <?php
                                echo h($leaveRequest->reject_reason)
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
                <div class="form-actions">
                    <?php
                    echo $this->Html->link(
                        __('Back'),
                        ['action' => 'index'], ['class' => 'btn btn-inverse']
                    );
                    ?>
                    <?php
                    $reporting_manager = $leaveRequest->employee['reporting_manager'];
                    if(($isReportingManager == $reporting_manager || $roleId == 2 ) && $leaveRequest->is_approved == 0):  ?>
                    <?php    echo $this->Html->link(
                            __('Approve'),
                            ['action' => 'approve',1,$leaveRequest->id,$leaveRequest->employee_id,$leaveRequest->leave_type,$leaveRequest->half_day], ['class' => 'btn btn-success']
                        ); ?>

                        <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">reject</button>           
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h4>Reject Reeason:</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <?php echo $this->Form->create($leaveRequest, ['url' => ['action' => 'rejectReason',2,$leaveRequest->id,$leaveRequest->employee_id,$leaveRequest->leave_type,$leaveRequest->half_day]]) ?>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->control(
                                            'reject_reason', [
                                                'label' => [
                                                    'class' => 'control-label'
                                                ],
                                                'class' => 'form-control'
                                                ]
                                            );
                                            
                                            echo $this->Form->text(
                                                'is_approved', [
                                                    'class' => 'form-control',
                                                    'value' => 2,
                                                    'hidden'=>'true'
                                                ]
                                            );
                                            
                                            echo $this->Form->text(
                                                'approved_by', [
                                                    'class' => 'form-control',
                                                    'value' => 2,
                                                    'hidden'=>'true',
                                                    'value' => $userName
                                                ]
                                            );
                                            echo $this->Form->text(
                                                'date_from', [
                                                    'class' => 'form-control',
                                                    'hidden'=>'true',
                                                    'value' => $leaveRequest->date_from
                                                ]
                                            );
                                            echo $this->Form->text(
                                                'date_to', [
                                                    'class' => 'form-control',
                                                    'hidden'=>'true',
                                                    'value' => $leaveRequest->date_to
                                                ]
                                            );
                                            echo $this->Form->text(
                                                'leave_reason', [
                                                    'class' => 'form-control',
                                                    'hidden'=>'true',
                                                    'value' => $leaveRequest->leave_reason
                                                ]
                                            );
                                            echo $this->Form->text(
                                                'reliever', [
                                                    'class' => 'form-control',
                                                    'hidden'=>'true',
                                                    'value' => $leaveRequest->reliever
                                                ]
                                            );
                                            echo $this->Form->text(
                                                'applicant', [
                                                    'class' => 'form-control',
                                                    'hidden'=>'true',
                                                    'value' => $leaveRequest->employee_id
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->Form->button(__('Submit'), ['type' => 'submit','class' => 'btn btn-danger mr-1']); ?>
                    <?php echo $this->Form->end() ?>
                </div>                        
            </div>
            <!-- <div class="modal-footer">      
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
