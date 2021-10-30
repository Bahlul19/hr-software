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
            <div class="card-header" style="text-align: center">
                <h4 class="m-b-0 text-white">Utilize Requests for CompOff</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('employee_name','Employee'); ?> </th>
                            <th scope="col"><?= $this->Paginator->sort('date','Date'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('utilize_hours','Utilize Hours'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('approved_by','Approved by'); ?></th>
                            <th scope="col"><?= $this->Paginator->sort('status','Status');?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($utilizeComoffs as $utilizeComoff): ?>
                            <?php if($roleId <= 2 || $is_manager == 1 || $utilizeComoff->employee_id == $employeeId) {?>
                                <tr>
                                    <td><?= $this->Html->link($utilizeComoff->employee_name, ['controller' => 'Employees', 'action' => 'view', $utilizeComoff->employee->id]) ?></td>
                                    <td><?= date('m/d/Y',strtotime(h($utilizeComoff->date))); ?></td>
                                    <td><?= $this->Number->format($utilizeComoff->utilize_hours) ?></td>
                                    <td>
                                        <?php
                                            if($utilizeComoff->approved_by != null){
                                                echo $utilizeComoff->approved_by;
                                            } else {
                                                echo "-";
                                            }
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                            if($utilizeComoff->status == 0){
                                                echo "Pending";
                                            } elseif ($utilizeComoff->status == 1){
                                                echo "Approved";
                                            } elseif($utilizeComoff->status == 2) {
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
                                            ['action' => 'view', $utilizeComoff->id],
                                            [
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'View'
                                            ]
                                        );
                                    ?>
                                    <?php
                                        if( $utilizeComoff->status == 0 && ( $roleId <= 2 || $is_manager == 1 ) )
                                        {
                                            $nowTime = date('Y-m-d');
                                            $comoffDate = date('Y-m-d', strtotime($utilizeComoff->date));

                                            if(($nowTime === $comoffDate) || ($nowTime < $comoffDate)){

                                                echo $this->Html->link(
                                                    __(
                                                        $this->Html->tag('i', '', array('class' => 'fa fa-check text-inverse m-r-10'))
                                                    ),
                                                    ['action' => 'utilizeComOffApproved', $utilizeComoff->id],
                                                    [
                                                        'escape' => false,
                                                        'data-toggle' => 'tooltip',
                                                        'data-original-title' => 'Approve'
                                                    ]
                                                );
                                            }
                                        }

                                        if($utilizeComoff->status == 0 || ( ( $roleId <= 2 || $is_manager == 1) && $utilizeComoff->status != 3) ) {
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10'))
                                                ),
                                                ['action' => 'edit', $utilizeComoff->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Edit'
                                                ]
                                            );
                                        }
                                    ?>
                                    <?php
                                        if( ($roleId == 4 && $utilizeComoff->status == 0) || $roleId <= 2 || $is_manager == 1) {
                                            echo $this->Form->postLink(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10'))
                                                ),
                                                ['action' => 'delete', $utilizeComoff->id],
                                                [
                                                    'confirm' => __('Are you sure you want to delete {0}?', $utilizeComoff->employee_name),
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Delete'
                                                ]
                                            );
                                        }
                                    ?>

                                    <?php

                                        if($utilizeComoff->status == 0){
                                            $nowTime = date('Y-m-d');
                                            $comoffDate = date('Y-m-d', strtotime($utilizeComoff->date));

                                            if(($nowTime === $comoffDate) || ($nowTime < $comoffDate))
                                            {
                                                if($utilizeComoff->status == 0 ||$utilizeComoff->status == 1) {
                                                    echo $this->Html->link(
                                                        __(
                                                            $this->Html->tag('i', '', array('class' => 'fa fa-times text-inverse m-r-10'))
                                                        ),
                                                        ['action' => 'utilizeComoffRequestCancellation', $utilizeComoff->id],
                                                        [
                                                            'escape' => false,
                                                            'data-toggle' => 'tooltip',
                                                            'data-original-title' => 'Cancel'
                                                        ]
                                                    );
                                                }
                                            }
                                        }
                                    ?>
                                </td>
                                </tr>
                            <?php }?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php echo $this->element('pagination'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
