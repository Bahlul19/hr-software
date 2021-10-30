<div class="row employees">
    <div class="col-lg-6 search">
        <?php echo $this->Form->create(false, ['type' => 'GET']); ?>
            <div class="input-group">
            <div class="input-group-addon">
                <i class="ti-search"></i>
            </div>
            <?php
                echo $this->Form->control(
                    'search', [
                        'templates' => [
                            'inputContainer' => '{{content}}'
                        ],
                        'required' => true,
                        'value' => !empty($keyword) ? $keyword : '',
                        'class' => 'form-control',
                        'id'    =>  'search',
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
    </div>

    <div class="col-lg-6 search">
        <div class="form-group">
            <select name="office_location" class="form-control office-location" id="office-location-emp-list" aria-required="true">
                <option value="">Select Office</option>
                <option value="NYC">NYC</option>
                <option value="SYL">SYL</option>
                <option value="GOA">GOA</option>
                <option value="DHK">DHK</option>
                <option value="UKR">UKR</option>
            </select>
        </div>
    </div>
</div>

<div class="row employees">
   <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info">
            <?php echo $this->element('employee-list/employee-list-tab'); ?>
            <div class="card-header">
                <h4 class="m-b-0 text-white">Current Employees</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="emp-list-table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo $this->Paginator->sort('Employees.first_name', 'Name'); ?></th>
                                <th><?php echo $this->Paginator->sort('Designations.title' ,'Designation') ?></th>
                                <th class="text-center"><?php echo $this->Paginator->sort('Employees.office_location' ,'Location') ?></th>
                                <th class="text-center"><?= $this->Paginator->sort('Salary'); ?></th>
                                <th class="text-center">Actions</th>
                                <th class="text-center">Skills Graph</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td>
                                    <?php
                                        $employeeName = h($employee->first_name)." ".$employee->last_name;
                                        echo $employeeName;
                                    ?>
                                </td>
                                <td><?php echo h($employee->designation->title) ?></td>
                                <td class="text-center"><?php echo (h($employee->office_location)); ?></td>
                                <td class="actions text-center">
                                    <?php
                                        echo $this->Html->link(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10'))
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
                                    $hrRole = array(2);
                                    $adminRole = array(3);
                                    if(($loggedUser['role_id']) == 1){
                                        echo $this->Html->link(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10 icon-designation'))
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
                                                $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10 icon-designation'))
                                            ),
                                            ['action' => 'edit', $employee->id],
                                            [
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Edit'
                                            ]
                                        );

                                        echo $this->Form->postLink(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10 icon-designation'))
                                            ),
                                            ['action' => 'delete', $employee->id],
                                            [
                                                'confirm' => __('Are you sure you want to delete {0}?', $employee->first_name),
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Delete'
                                            ]
                                        );
                                    }
                                    else if(in_array($loggedUser['role_id'], $hrRole) && $employee['role_id'] != 1){
                                        echo $this->Html->link(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10 icon-designation'))
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
                                                $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10 icon-designation'))
                                            ),
                                            ['action' => 'edit', $employee->id],
                                            [
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Edit'
                                            ]
                                        );

                                        echo $this->Form->postLink(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10 icon-designation'))
                                            ),
                                            ['action' => 'delete', $employee->id],
                                            [
                                                'confirm' => __('Are you sure you want to delete {0}?', $employee->first_name),
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Delete'
                                            ]
                                        );
                                    }
                                    else if(in_array($loggedUser['role_id'], $adminRole) && ($employee['role_id'] != 1) && $employee['role_id'] != 2){
                                        echo $this->Html->link(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10 icon-designation'))
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
                                                $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10 icon-designation'))
                                            ),
                                            ['action' => 'edit', $employee->id],
                                            [
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Edit'
                                            ]
                                        );

                                        echo $this->Form->postLink(
                                            __(
                                                $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10 icon-designation'))
                                            ),
                                            ['action' => 'delete', $employee->id],
                                            [
                                                'confirm' => __('Are you sure you want to delete {0}?', $employee->first_name),
                                                'escape' => false,
                                                'data-toggle' => 'tooltip',
                                                'data-original-title' => 'Delete'
                                            ]
                                        );
                                    }
                                ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                        echo $this->Html->link(__($this->Html->tag('i', '', array('class'=> 'fa fa-line-chart'))),['controller' => 'employee_skills','action' => 'skills_graph', $employee->id],[
                                            'escape' => false,
                                            'data-toggle' => 'tooltip',
                                            'data-original-title' => 'Edit'
                                        ]);
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
