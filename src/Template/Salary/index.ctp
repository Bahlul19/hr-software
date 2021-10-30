<div class="row designation" id="leave-request">
    <div class="col-md-12">
        <div class="form-actions" style="text-align:right;">
            <br>
            <?php
                echo $this->Html->link(
                    __('Pending'),
                    ['action' => 'pending'], ['class' => 'btn btn-primary']
                );
            ?>
        </div>
    </div>
</div>
<div class="row designation">
   <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Salary</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('employee_id') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('employee_name') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('salary') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('reason') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                    <th scope="col" class="actions"><?//= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($salary as $salary): ?>
                                <tr>                
                                    <td><?= $this->Number->format($salary->id) ?></td>
                                    <td><?= $salary->has('employee') ? $this->Html->link($salary->employee->first_name.' '.$salary->employee->last_name, ['controller' => 'Employees', 'action' => 'view', $salary->employee->id]) : '' ?></td>
                                    <td><?= h($salary->employee->first_name) ?></td>
                                    <td><?= $this->Number->format($salary->salary_amount) ?></td>
                                    <td><?= h($salary->reason) ?></td>
                                    <td><?= date('m/d/Y', strtotime(h($salary->modified))) ?></td>
                                    <td><?= date('m/d/Y', strtotime(h($salary->created))) ?></td>
                                   <td class="actions">
                                        <?php
//                                            echo $this->Html->link(
//                                                __(
//                                                    $this->Html->tag('i', '', array('class' => 'fa fa-eye text-inverse m-r-10'))
//                                                ),
//                                                ['action' => 'view', $salary->id,$salary->employee_id],
//                                                [
//                                                    'escape' => false,
//                                                    'data-toggle' => 'tooltip',
//                                                    'data-original-title' => 'View'
//                                                ]
//                                            );
//
//                                            echo $this->Html->link(
//                                                __(
//                                                    $this->Html->tag('i', '', array('class' => 'fa fa-pencil text-inverse m-r-10'))
//                                                ),
//                                                ['action' => 'edit', $salary->id,$salary->employee_id],
//                                                [
//                                                    'escape' => false,
//                                                    'data-toggle' => 'tooltip',
//                                                    'data-original-title' => 'Edit'
//                                                ]
//                                            );
//
//                                            echo $this->Form->postLink(
//                                                __(
//                                                    $this->Html->tag('i', '', array('class' => 'fa fa-trash text-inverse m-r-10'))
//                                                ),
//                                                ['action' => 'delete', $salary->id],
//                                                [
//                                                    'confirm' => __('Are you sure you want to delete {0}?', $salary->employee->first_name.' '.$salary->employee->last_name),
//                                                    'escape' => false,
//                                                    'data-toggle' => 'tooltip',
//                                                    'data-original-title' => 'Delete'
//                                                ]
//                                            );
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
