<div class="row leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Leave Requests</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                        <th scope="col"><?= $this->Paginator->sort('employee_name','Employee'); ?> </th>
                            <th scope="col"><?= $this->Paginator->sort('leave_type','Leave Type'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('date_to','Date Form'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('date_to','Date To'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('modified','Approved Rejected'); ?></th>
                            
                            <th scope="col"><?= $this->Paginator->sort('office_location','Office Location'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('no_of_days','No. Of Days'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('half_day','Half Day'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('reliever','Reliever'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('is_approved','Status');?></th>
                        </tr>
                        </thead>
                        <tbody>

                            <p><?= $todaysSylhetLeaveMemberName ?></p>

                           <?php foreach ($todayLeaveRequest as $todayLeaveRequests): ?>

                            <p><b>Subject : Leave applications for </b> <?= $todayLeaveRequests->created; ?></p>

                        <?php endforeach ?>

                        <h5>

                        <?= $todaysGoaLeave ?> leave applications in <?= $officeLocationGoa ?> Office + <?= $todaysSylhetLeave ?> leave applications in <?= $officeLocationSylhet ?>
                            
                        </h5>    

                        <?php foreach ($todayLeaveRequest as $todayLeaveRequests): ?>
                            <tr>
                                <td><?= $todayLeaveRequests->has('employee') ? $this->Html->link($todayLeaveRequests->employee->first_name, ['controller' => 'Employees', 'action' => 'view', $todayLeaveRequests->employee->id]) : '' ?></td>
                                <?php
                                if(h($todayLeaveRequests->leave_type) == 1){
                                    $leaveType="Sick Leave";
                                } elseif(h($todayLeaveRequests->leave_type) == 2){
                                    $leaveType="Casual Leave";
                                } elseif(h($todayLeaveRequests->leave_type) == 3){
                                    $leaveType="LWoP Leave";
                                } elseif(h($todayLeaveRequests->leave_type) == 5){
                                    $leaveType="Un-Planned Leave";
                                }  elseif(h($todayLeaveRequests->leave_type) == 6){
                                    $leaveType="Planned Leave";
                                } elseif(h($todayLeaveRequests->leave_type) == 7){
                                    $leaveType="Restricted Leave";
                                }  elseif(h($todayLeaveRequests->leave_type) == 8){
                                    $leaveType="Day Off";
                                }  else {
                                    $leaveType="Earned Leave";
                                }
                                ?>
                                <td><?= $leaveType;?></td>

                                <td><?= date('m/d/Y',strtotime(h($todayLeaveRequests->date_from))); ?></td>
                                <td><?= date('m/d/Y',strtotime(h($todayLeaveRequests->date_to)));?></td>
                                <td><?= date('m/d/Y',strtotime(h($todayLeaveRequests->modified)));?></td>
                                 <td><?= $todayLeaveRequests->employee->office_location;?>
                                     
                                 </td>
                                <td><?= $this->Number->format($todayLeaveRequests->no_of_days) ?></td>
                                <td><?php
                                    if($todayLeaveRequests->half_day == 1){
                                        echo "First Half";
                                    } elseif($todayLeaveRequests->half_day == 2){
                                        echo "Second Half";
                                    } else {
                                        echo "-";
                                    }
                                    ?></td>
                                    <td><?= h($todayLeaveRequests->reliever);?></td>
                                    <td><?php
                                        if($todayLeaveRequests->is_approved == 0){
                                            echo "Pending";
                                        } elseif ($todayLeaveRequests->is_approved == 1){
                                            echo "Approved";
                                        } elseif($todayLeaveRequests->is_approved == 2) {
                                            echo "Rejected";
                                        } else {
                                            echo "Cancelled";
                                        }
                                    ?></td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                   
                </div>
            </div>
        </div>
    </div>
</div>
