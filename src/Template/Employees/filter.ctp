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
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php echo $this->element('pagination'); ?>