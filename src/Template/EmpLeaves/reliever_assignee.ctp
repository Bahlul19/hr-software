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
                            <th scope="col"><?= $this->Paginator->sort('date_from','Date From'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('date_to','Date To'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('modified','Modified'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('no_of_days','No. Of Days'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('half_day','Half Day'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('reliever','Reliever'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('reliever_approved','Reliever Approved By'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('reliever_rejected','Reliever Rejected By'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('is_approved','HR Status');?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($leaveRequests as $leaveRequest): ?>
                            <tr>
                                <td><?= $leaveRequest->employee_name; ?></td>
                                <?php
                                if(h($leaveRequest->leave_type) == 1){
                                    $leaveType="Sick Leave";
                                } elseif(h($leaveRequest->leave_type) == 2){
                                    $leaveType="Casual Leave";
                                } elseif(h($leaveRequest->leave_type) == 3){
                                    $leaveType="LWoP Leave";
                                } elseif(h($leaveRequest->leave_type) == 5){
                                    $leaveType="Un-Planned Leave";
                                } elseif(h($leaveRequest->leave_type) == 6){
                                    $leaveType="Planned Leave";
                                } elseif(h($leaveRequest->leave_type) == 7){
                                    $leaveType="Restricted Leave";
                                }  elseif(h($leaveRequest->leave_type) == 8){
                                    $leaveType="Day Off";
                                }  else {
                                    $leaveType = "Earned Leave";
                                }
                                ?>
                                <td><?= $leaveType;?></td>

                                <td><?= date('m/d/Y',strtotime(h($leaveRequest->min_date))); ?></td>
                                <td><?= date('m/d/Y',strtotime(h($leaveRequest->max_date)));?></td>
                                <td><?= date('m/d/Y',strtotime(h($leaveRequest->modified)));?></td>
                                <td><?= $this->Number->format($leaveRequest->number_of_days) ?></td>
                                <td><?php
                                    if($leaveRequest->half_day == 1){
                                        echo "First Half";
                                    } elseif($leaveRequest->half_day == 2){
                                        echo "Second Half";
                                    } else {
                                        echo "-";
                                    }
                                    ?></td>
                                    <td>
                                        <?php
                                            $selectedReliever = $leaveRequest->reliever;
                                            $selectedReliever=trim($selectedReliever,",");
                                            // debug($selectedReliever);
                                            $relieverList = explode(',', $selectedReliever);
                                            foreach ($relieverList as $rl) :
                                                if($rl != "") {
                                                    echo "<p style='font-size: 12px;'>" . $this->Html->link(\App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl), ['controller' => 'Employees', 'action' => 'view', $rl]) . "</p>";
                                                }
                                                //echo \App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl);
                                                ?>
                                        <?php endforeach;?>
                                    </td>
                                    <td>
                                        <?php
                                        $relieverApprovedList=[];
                                        $selectedRelieverApproved = $leaveRequest->reliever_approved;
                                        if($selectedRelieverApproved == "0") {
                                            echo "None";
                                        }
                                        else {
                                            $selectedRelieverApproved=trim($selectedRelieverApproved,",");
                                            $relieverApprovedList = explode(',', $selectedRelieverApproved);
                                            foreach ($relieverApprovedList as $rl) :
                                                if($rl != "") {
                                                    echo "<p style='font-size: 12px;'>" . $this->Html->link(\App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl), ['controller' => 'Employees', 'action' => 'view', $rl]) . "</p>";
                                                }
                                                //echo \App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl);
                                                ?>
                                            <?php endforeach;
                                        }?>
                                    </td>

                                    <td>
                                        <?php
                                        $relieverRejectedList=[];
                                        $selectedRelieverRejected = $leaveRequest->reliever_rejected;

                                        if($selectedRelieverRejected == "0") {
                                            echo "None";
                                        }
                                        else {
                                            $selectedRelieverRejected=trim($selectedRelieverRejected,",");
                                            $relieverRejectedList = explode(',', $selectedRelieverRejected);
                                            foreach ($relieverRejectedList as $rl) :
                                                if($rl != "") {
                                                    echo "<p style='font-size: 12px;'>" . $this->Html->link(\App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl), ['controller' => 'Employees', 'action' => 'view', $rl]) . "</p>";
                                                }
                                                //echo \App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl);
                                                ?>

                                            <?php endforeach;
                                        }?>
                                    </td>

                                    <td>
                                        <?php
                                        // debug($leaveRequest->is_approved);
                                        if($leaveRequest->is_approved == 0){
                                            echo "Pending";
                                        } elseif ($leaveRequest->is_approved == 1){
                                            echo "Approved";
                                        } elseif($leaveRequest->is_approved == 2) {
                                            echo "Rejected";
                                        } else {
                                            echo "Cancelled";
                                        }
                                        ?>
                                    </td>
                                    
                                <td class="actions">
                                    <?php 
                                         echo $this->Html->link(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10'))
                                            ),
                                            ['action' => 'view', $leaveRequest->ids],
                                            [
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'View'
                                            ]
                                        );
                                    ?>

                                    <?php
                                        if($leaveRequest->reliever_status == 0)
                                        {
                                            if(!empty($relieverApprovedList)) {
                                                $inApprovedList = in_array($employeeId, $relieverApprovedList);
                                            }
                                            else {
                                                $inApprovedList = false;
                                            }

                                            if(isset($relieverRejectedList)) {
                                                $inRejectList = in_array($employeeId, $relieverRejectedList);
                                            }
                                            else {
                                                $inRejectList = false;
                                            }

                                            if(!$inApprovedList && !$inRejectList && ($leaveRequest->is_approved == 0)) {
                                                $nowTime = date('Y-m-d');
                                                $leaveRequestDate = date('Y-m-d', strtotime($leaveRequest->date_from));
                                                 if(($nowTime === $leaveRequestDate) || ($nowTime < $leaveRequestDate)){

                                                    echo $this->Html->link(
                                                        __(
                                                            $this->Html->tag('i', '', array('class' => 'fa fa-check text-inverse m-r-10'))
                                                        ),
                                                        ['action' => 'relieverResponsForLeaveApprove', $leaveRequest->ids],
                                                        [
                                                            'escape' => false,
                                                            'data-toggle' => 'tooltip',
                                                            'data-original-title' => 'Accept'
                                                        ]
                                                    );
                                                 }
                                             }
                                        }
                                    ?>

                                     <?php
                                        if(isset($relieverApprovedList)) {
                                            $inApprovedList = in_array($employeeId, $relieverApprovedList);
                                        }
                                        else {
                                            $inApprovedList = false;
                                        }

                                        if(isset($relieverRejectedList)) {
                                            $inRejectList = in_array($employeeId, $relieverRejectedList);
                                        }
                                        else {
                                            $inRejectList = false;
                                        }

                                        if(!$inApprovedList && !$inRejectList && ($leaveRequest->is_approved == 0)) {
                                            $nowTime = date('Y-m-d');
                                            $leaveRequestDate = date('Y-m-d', strtotime($leaveRequest->date_from));
                                            if (($nowTime === $leaveRequestDate) || ($nowTime < $leaveRequestDate)) {

                                                echo $this->Html->link(
                                                    __(
                                                        $this->Html->tag('i', '', array('class' => 'fa fa-times text-inverse m-r-10'))
                                                    ),
                                                    ['action' => 'relieverResponsForLeaveReject', $leaveRequest->ids],
                                                    [
                                                        'escape' => false,
                                                        'data-toggle' => 'tooltip',
                                                        'data-original-title' => 'Reject'
                                                    ]
                                                );
                                            }
                                        }
                                    ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php echo $this->element('pagination'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
