<div class="row employees">
    <div class="col-md-6 search">

        <?php if($roleId !=4) { ?>

            <?php echo $this->Form->create(false, ['type' => 'GET']); ?>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="ti-search"></i>
                </div>
                <?php
                echo $this->Form->control(
                    'keyword', [
                        'templates' => [
                            'inputContainer' => '{{content}}'
                        ],
                        'required' => true,
                        'class' => 'form-control emp-list-leave-report',
                        'empty' => 'Select Employee',
                        'options' => $employees,
                        'maxlength'=>100,
                        'label' =>  ''
                    ]
                );
                ?>
                <span class="input-group-btn">
                    <?php
                    echo $this->Form->button(
                        'Search', [
                            'type' => 'submit',
                            'class' => 'btn btn-info',
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ],
                            'data-toggle' => 'tooltip',
                            'data-original-title' => 'Search'
                        ]
                    );

                    if (!empty($keyword)) {
                        echo $this->Html->Link(
                            __(
                                'Clear'
                            ),
                            ['action' => 'index'],
                            [
                                'class' => 'btn btn-warning',
                                'escape' => false,
                                'data-toggle' => 'tooltip',
                                'data-original-title' => 'Clear'
                            ]
                        );
                    }
                    ?>
                </span>
            </div>

            <?php echo $this->Form->end(); ?>

        <?php } ?>

    </div>

    <div class="col-md-6">
        <div class="form-actions" style="text-align:right; margin-bottom: 20px">
        <?php
                // if($roleId !=4) { echo $this->Html->link(
                //     __('Show Group'),
                //     ['action' => '#'], ['class' => 'btn btn-secondary','id'=>'toggleView']
                // );
                // }
            ?>
            <?php
            echo $this->Html->link(
                __('All'),
                ['action' => 'index'], ['class' => 'btn btn-primary']
            );?>
            <?php
            echo $this->Html->link(
                __('Pending'),
                ['action' => 'pending'], ['class' => 'btn btn-primary']
            );?>
            <?php
            echo $this->Html->link(
                __('Approved'),
                ['action' => 'approved'], ['class' => 'btn btn-success']
            );?>
            <?php
            echo $this->Html->link(
                __('Rejected    '),
                ['action' => 'rejected'], ['class' => 'btn btn-danger']
            );
            ?>
        </div>
    </div>
</div>
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
                            <th scope="col"><?= $this->Paginator->sort('modified','Date Of Request'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('no_of_days','No. Of Days'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('half_day','Half Day'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('reliever_name','Reliever'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('reliever_approved','Reliever Approved'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('reliever_rejected','Reliever Rejected'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('is_approved','HR Status');?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
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
                                <td><?= h($leaveRequest->reliever_name);?></td>
                                <td>
                                    <?php
                                    $selectedRelieverApproved = $leaveRequest->reliever_approved;

                                    if($selectedRelieverApproved == "0") {
                                        echo "None";
                                    }

                                    else {
                                        $relieverApprovedList = explode(',', $selectedRelieverApproved);
                                        foreach ($relieverApprovedList as $rl) :
                                            if($rl != "") {
                                                echo "<p style='font-size: 12px;'>" . $this->Html->link(\App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl), ['controller' => 'Employees', 'action' => 'view', $rl]) . "</p>";
                                            }
                                           
                                            ?>

                                        <?php endforeach;
                                    }?>
                                </td>

                                <td>
                                    <?php
                                    $selectedRelieverRejected = $leaveRequest->reliever_rejected;

                                    if($selectedRelieverRejected == "0") {
                                        echo "None";
                                    }

                                    else {
                                        $relieverRejectedList = explode(',', $selectedRelieverRejected);
                                        foreach ($relieverRejectedList as $rl) :
                                            if($rl != "") {
                                                echo "<p style='font-size: 12px;'>" . $this->Html->link(\App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl), ['controller' => 'Employees', 'action' => 'view', $rl]) . "</p>";
                                            }
                                           
                                            ?>

                                        <?php endforeach;
                                    }?>
                                </td>

                                <td>
                                    <?php
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
                                        ['action' => 'view', $leaveRequest->id],
                                        [
                                            'escape' => false,
                                            'data-toggle' => 'tooltip',
                                            'data-original-title' => 'View'
                                        ]
                                    );
                                    ?>
                                    <?php
                                    if($leaveRequest->is_approved == 0 || $roleId == 2) {
                                        echo $this->Html->link(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10'))
                                            ),
                                            ['action' => 'edit', $leaveRequest->id],
                                            [
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Edit'
                                            ]
                                        );
                                    }
                                    ?>
                                    <?php
                                    if($roleId == 2) {
                                        echo $this->Form->postLink(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10'))
                                            ),
                                            ['action' => 'delete', $leaveRequest->id],
                                            [
                                                'confirm' => __('Are you sure you want to delete {0}?', $leaveRequest->first_name),
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Delete'
                                            ]
                                        );
                                    }
                                    ?>

                                    <?php

                                    if($roleId == 2){
                                        $nowTime = date('Y-m-d');
                                        $leaveRequestDate = date('Y-m-d', strtotime($leaveRequest->date_from));

                                        if(($nowTime === $leaveRequestDate) || ($nowTime < $leaveRequestDate))
                                        {
                                            if($leaveRequest->is_approved == 0 ||$leaveRequest->is_approved == 1) {
                                                echo $this->Html->link(
                                                    __(
                                                        $this->Html->tag('i', '', array('class' => 'fa fa-times text-inverse m-r-10'))
                                                    ),
                                                    ['action' => 'employeesLeaveCancellation', $leaveRequest->id],
                                                    [
                                                        'escape' => false,
                                                        'data-toggle' => 'tooltip',
                                                        'data-original-title' => 'Cancel'
                                                    ]
                                                );
                                            }
                                        }
                                    }
                                    else if($roleId == 4 && $leaveRequest->is_approved == 0) {
                                        $nowTime = date('Y-m-d');
                                        $leaveRequestDate = date('Y-m-d', strtotime($leaveRequest->date_from));

                                        if(($nowTime === $leaveRequestDate) || ($nowTime < $leaveRequestDate))
                                        {
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-times text-inverse m-r-10'))
                                                ),
                                                ['action' => 'employeesLeaveCancellation', $leaveRequest->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Cancel'
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
