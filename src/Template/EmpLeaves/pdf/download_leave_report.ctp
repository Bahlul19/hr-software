<div class="table-responsive" width="100% !important" id="leaveReport">
    <table class="table table-hover" width = "100% !important">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('employee_name','Employee'); ?> </th>
                <th scope="col"><?= $this->Paginator->sort('leave_type','Leave Type'); ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_from','Date From'); ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_to','Date To'); ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified','Approved Rejected'); ?></th>
                <th scope="col"><?= $this->Paginator->sort('no_of_days','No. Of Days'); ?></th>
                <th scope="col"><?= $this->Paginator->sort('half_day','Half Day'); ?></th>
                <th scope="col"><?= $this->Paginator->sort('reliever','Reliever'); ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_approved','Status');?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($leaveRequests as $leaveRequest): ?>
            <tr>
                <td><?= $leaveRequest->has('employee') ? $this->Html->link($leaveRequest->employee->first_name, ['controller' => 'Employees', 'action' => 'view', $leaveRequest->employee->id]) : '' ?></td>
                <?php
                if(h($leaveRequest->leave_type) == 1){
                    $leaveType="Sick Leave";
                } elseif(h($leaveRequest->leave_type) == 2){
                    $leaveType="Casual Leave";
                } elseif(h($leaveRequest->leave_type) == 3){
                    $leaveType="LWoP Leave";
                } elseif(h($leaveRequest->leave_type) == 5){
                    $leaveType="Un-Planned Leave";
                }  elseif(h($leaveRequest->leave_type) == 6){
                    $leaveType="Planned Leave";
                } elseif(h($leaveRequest->leave_type) == 7){
                    $leaveType="Restricted Leave";
                }  elseif(h($leaveRequest->leave_type) == 8){
                    $leaveType="Day Off";
                }  else {
                    $leaveType="Earned Leave";
                }
                ?>
                <td><?= $leaveType;?></td>

                <td><?= date('m/d/Y',strtotime(h($leaveRequest->date_from))); ?></td>
                <td><?= date('m/d/Y',strtotime(h($leaveRequest->date_to)));?></td>
                <td><?= date('m/d/Y',strtotime(h($leaveRequest->modified)));?></td>
                <td><?= $this->Number->format($leaveRequest->no_of_days) ?></td>
                <td><?php
                    if($leaveRequest->half_day == 1){
                        echo "First Half";
                    } elseif($leaveRequest->half_day == 2){
                        echo "Second Half";
                    } else {
                        echo "-";
                    }
                    ?></td>
                    <td><?= h($leaveRequest->reliever);?></td>
                    <td><?php
                        if($leaveRequest->is_approved == 0){
                            echo "Pending";
                        } elseif ($leaveRequest->is_approved == 1){
                            echo "Approved";
                        } elseif($leaveRequest->is_approved == 2) {
                            echo "Rejected";
                        } else {
                            echo "Cancelled";
                        }
                    ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $this->element('pagination'); ?>
</div>