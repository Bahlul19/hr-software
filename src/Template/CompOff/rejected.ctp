<div class="row leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <!--            <div class="card-header">-->
            <!--                <h4 class="m-b-0 text-white">CompOff Requests</h4>-->
            <!--            </div>-->

            <div class="row">
                <div class="col-md-6 search">

                    <?php if($loggedUserRole !=4) { ?>

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
                    <div class="form-actions" style="text-align:right; margin-top: 20px">
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

            <div class="card-header" style="width: 100%; text-align: center; background-color: #0091D5; margin-top: 10px">
                <h2 class="m-b-0" style="color: #ffffff">Your CompOff Requests Approved hour: <?= $compOffApprovedSum;?> hours</h2>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('number_of_hours') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('pm_name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('team_name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('name_of_the_project') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </thead>
                        <tbody>
                        <?php foreach ($compOff as $compOffs): ?>
                            <?php
                            if($loggedUserRole <= 3 || $is_manager == 1 || $compOffs->employee_id == $loggedInUserId) {
                                ?>
                                <tr>
                                    <td><?= $this->Html->link($compOffs->name, ['controller' => 'Employees', 'action' => 'view', $compOffs->employee_id])?></td>
                                    <td><?= $compOffs->date; ?></td>
                                    <td><?= $compOffs->number_of_hours; ?></td>
                                    <td><?= $this->Html->link($compOffs->pm_name, ['controller' => 'Employees', 'action' => 'view', $compOffs->pm_id])?></td>
                                    <td><?= $compOffs->team_name; ?></td>
                                    <td><?= $compOffs->name_of_the_project; ?></td>
                                    <td><?php
                                        if($compOffs->status == 0){
                                            echo "Pending";
                                        } elseif ($compOffs->status == 1){
                                            echo "Approved";
                                        } elseif($compOffs->status == 2) {
                                            echo "Rejected";
                                        } else {
                                            echo "Cancelled";
                                        }
                                        ?></td>

                                    <td class="actions">
                                        <?php
                                        echo $this->Html->link(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10'))
                                            ),
                                            ['action' => 'view', $compOffs->id],
                                            [
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'View'
                                            ]
                                        );
                                        ?>

                                        <?php
                                        if($compOffs->status == 0 && ($loggedUserRole == 2 || $is_manager == 1))
                                        {
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-check text-inverse m-r-10'))
                                                ),
                                                ['action' => 'comOffApproved', $compOffs->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Approve'
                                                ]
                                            );
                                        }

                                        if($compOffs->status == 0) {
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10'))
                                                ),
                                                ['action' => 'edit', $compOffs->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Edit'
                                                ]
                                            );
                                        } elseif($compOffs->status == 1 && (($loggedUserRole == 2 || $is_manager == 1))) {
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10'))
                                                ),
                                                ['action' => 'edit', $compOffs->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Edit'
                                                ]
                                            );
                                        }
                                        ?>

                                        <?php
                                        if($compOffs->status == 0)
                                        {
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-times text-inverse m-r-10'))
                                                ),
                                                ['action' => 'comOffRejected', $compOffs->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Cancel'
                                                ]
                                            );
                                        }

                                        if($compOffs->status != 1) {
                                            echo $this->Form->postLink(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10'))
                                                ),
                                                ['action' => 'delete', $compOffs->id],
                                                [
                                                    'confirm' => __('Are you sure you want to delete {0}?', $compOffs->id),
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Delete'
                                                ]
                                            );
                                        }
                                        ?>

                                    </td>
                                </tr>
                            <?php }?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php echo $this->element('compoff_pagination'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
