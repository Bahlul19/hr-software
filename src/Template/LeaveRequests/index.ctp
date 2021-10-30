<!--<div class="row leave-request">-->
<!--    <div class="col-lg-12 search">-->
<!--        --><?php //echo $this->Form->create(false, ['type' => 'GET']); ?>
<!--        <div class="input-group">-->
<!--            <div class="input-group-addon">-->
<!--                <i class="ti-search"></i>-->
<!--            </div>-->
<!--            --><?php
//            echo $this->Form->control(
//                'search', [
//                    'templates' => [
//                        'inputContainer' => '{{content}}'
//                    ],
//                    'required' => true,
//                    'value' => !empty($keyword) ? $keyword : '',
//                    'class' => 'form-control',
//                    'id'    =>  'search',
//                    'label' =>  '',
//                    'placeholder' => 'Search By Name.'
//                ]
//            );
//            ?>
<!--            <span class="input-group-btn">-->
<!--                --><?php
//                    echo $this->Form->button(
//                        'Search', [
//                            'type' => 'submit',
//                            'class' => 'btn btn-info',
//                            'templates' => [
//                                'inputContainer' => '{{content}}'
//                            ],
//                            'data-toggle' => 'tooltip',
//                            'data-original-title' => 'Search'
//                        ]
//                    );
//
//                    if (!empty($keyword)) {
//                        echo $this->Html->Link(
//                            __(
//                                'Clear'
//                            ),
//                            ['action' => 'index'],
//                            [
//                                'class' => 'btn btn-warning',
//                                'escape' => false,
//                                'data-toggle' => 'tooltip',
//                                'data-original-title' => 'Clear'
//                            ]
//                        );
//                    }
//                ?>
<!--            </span>-->
<!--        </div>-->
<!--        --><?php //echo $this->Form->end(); ?>
<!--    </div>-->
<!--</div>-->

<div class="row" id="leave-request">
    <div class="col-md-12">
        <div class="form-actions" style="text-align:right;">
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
                            <th scope="col"><?= $this->Paginator->sort('no_of_days','No. Of Days'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('half_day','Half Day'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('reliever','Reliever'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('is_approved','Status');?></th>
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
                                <!-- <td><?//= h($leaveRequest->leave_type) ?></td> -->
                                <td><?= $leaveType;?></td>

                                <td><?= date('m/d/Y',strtotime(h($leaveRequest->date_from))); ?></td>
                                <td><?= date('m/d/Y',strtotime(h($leaveRequest->date_to)));?></td>
                                <td><?= $this->Number->format($leaveRequest->no_of_days) ?></td>
                                <td><?php
                                    if($leaveRequest->half_day == 1){
                                        // $this->Number->format($leaveRequest->available_leave)
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
                                            // $this->Number->format($leaveRequest->available_leave)
                                            echo "Pending";
                                        } elseif ($leaveRequest->is_approved == 1){
                                            echo "Approved";
                                        } else {
                                            echo "Rejected";
                                        }
                                    ?></td>

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
                                     if($leaveRequest->is_approved == 0) {
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
                                        //echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $leaveRequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveRequest->id)])
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
