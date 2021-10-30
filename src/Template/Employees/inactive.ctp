<!--<div class="row employees">-->
<!--    <div class="col-lg-12 search">-->
<!--        --><?php //echo $this->Form->create(false, ['type' => 'GET']); ?>
<!--            <div class="input-group">-->
<!--            <div class="input-group-addon">-->
<!--                <i class="ti-search"></i>-->
<!--            </div>-->
<!--            --><?php
//                echo $this->Form->control(
//                    'search', [
//                        'templates' => [
//                            'inputContainer' => '{{content}}'
//                        ],
//                        'required' => true,
//                        'value' => !empty($keyword) ? $keyword : '',
//                        'class' => 'form-control',
//                        'id'    =>  'search',
//                        'label' =>  ''
//                    ]
//                );
//            ?>
<!--                <span class="input-group-btn">-->
<!--                    --><?php
//                        echo $this->Form->button(
//                            'Search', [
//                                'type' => 'submit',
//                                'class' => 'btn btn-info',
//                                'templates' => [
//                                    'inputContainer' => '{{content}}'
//                                ],
//                                'data-toggle' => 'tooltip',
//                                'data-original-title' => 'Search'
//                            ]
//                        );
//
//                        if (!empty($keyword)) {
//                            echo $this->Html->Link(
//                                __(
//                                    'Clear'
//                                ),
//                                ['action' => 'inactive'],
//                                [
//                                    'class' => 'btn btn-warning',
//                                    'escape' => false,
//                                    'data-toggle' => 'tooltip',
//                                    'data-original-title' => 'Clear'
//                                ]
//                            );
//                        }
//                    ?>
<!--                </span>-->
<!--            </div>-->
<!--            --><?php //echo $this->Form->end(); ?>
<!--    </div>-->
<!--</div>-->

<div class="row employees">
   <div class="col-lg-12">
        <div class="card card-outline-info">
            <?php echo $this->element('employee-list/employee-list-tab'); ?>
            <div class="card-header">
                <h4 class="m-b-0 text-white">Inactive Employees</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('Employees.first_name', 'Name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Designations.title' ,'Designation') ?></th>
                                    <th class="text-center"><?php echo $this->Paginator->sort('Employees.office_location' ,'Location') ?></th>
                                    <th class="text-center"><?= $this->Paginator->sort('Salary'); ?></th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($employees as $employee): ?>
                                <tr>
                                   <td><?php 
                                       $employeeName = h($employee->first_name)." ".$employee->last_name;
                                       echo $employeeName;
                                   ?></td>
                                   <td><?php echo h($employee->designation->title) ?></td>
                                   <td class="text-center"><?php echo (h($employee->office_location)); ?></td>
                                   <td class="actions text-center">
                                        <?php
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10 text-center'))
                                                ),
                                                ['controller'=>'Salary','action' => 'view', $employee->id,$employeeName],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'View'
                                                ]
                                            );
                                        ?>
                                    </td>
                                   <td class="actions text-center">
                                        <?php
                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10'))
                                                ),
                                                ['action' => 'view', $employee->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'View'
                                                ]
                                            );

                                            echo $this->Html->link(
                                                __(
                                                    $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10'))
                                                ),
                                                ['action' => 'edit', $employee->id],
                                                [
                                                    'escape' => false,
                                                    'data-toggle' => 'tooltip',
                                                    'data-original-title' => 'Edit'
                                                ]
                                            );
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
