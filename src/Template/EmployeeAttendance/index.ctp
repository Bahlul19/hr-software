<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeAttendance[]|\Cake\Collection\CollectionInterface $employeeAttendance
 */
?>
<?php echo $this->Form->create('searchAttendence',['id'=>'searchAttendence','type'=>'get']); ?>
<div class="row employees" style="padding: 20px;background-color: white;">
<?php if($optionAvail) { ?>
    <div class="col-md-6">
        <div class="form-group">
                <label for="emploee">Select Office</label>
                <select name="office_location" id="office_location" class="form-control" onchange="searchUsers();">
                    <option value="">Select Office</option>
                    <option value="NYC">NYC</option>
                    <option value="SYL">SYL</option>
                    <option value="GOA">GOA</option>
                    <option value="DHK">DHK</option>
                    <option value="UKR">UKR</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="emploees">Employee</label>
                <select id="emploees" name="emploees" class="form-control">
                </select>
            </div>
        </div>
    <?php } ?>
    <div class="col-md-6">
        <div class="form-group">
            <label for="from-date">From Date</label>
            <input type="date" name="from-date" id="from-date"  class="form-control" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="to-date">To Date</label>
            <input type="date" name="to-date" id="to-date" class="form-control" />
        </div>
    </div>
    <?php
         echo $this->Form->button(
         'Search', [
             'type' => 'submit',
             'class' => 'btn btn-info right-align',
             'id'=>'attendenceSearch',
             'templates' => [
                 'inputContainer' => '{{content}}'
             ],
             'data-toggle' => 'tooltip',
             'data-original-title' => 'Search'
        ]
       ); ?>
    <?php echo $this->Form->end(); ?>
</div>
<div class="row employees">
   <div class="col-lg-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Employees List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="emp-list-table">
                    <?php if (!$optionAvail) { ?>
                    <a href="/employee-attendance/weeklyData"><button class="btn btn-info right-align">Weekly Attendance</button></a>
                    <?php } ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('employee_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('shift') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('checkin') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('checkout') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('ot_hours') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('is_present') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('hours_worked') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employeeAttendance as $key => $employeeAttendance): ?>
                            <tr>
                               <?php 
                               $page_no=$this->request->query('page');
                               ?>
                                <td><?= ($key+1)+($page_no*10) ?></td>                                
                                <td><?= h($employeeAttendance->employee_name) ?></td>
                                <td><?= h($employeeAttendance->shift) ?></td>
                                <td><?= h(date('Y-m-d',strtotime($employeeAttendance->date))) ?></td>
                                <td><?= h(date('H:i',strtotime($employeeAttendance->checkin))) ?></td>
                                <td><?= h(date('H:i',strtotime($employeeAttendance->checkout))) ?></td>
                                <td>
                                    <?php                                         
                                        if (isset($employeeAttendance->extra_hours)) {
                                            echo "+".date('H:i',strtotime($employeeAttendance->extra_hours));    
                                        } elseif (isset($employeeAttendance->less_hours)) {
                                            echo "-".date('H:i',strtotime($employeeAttendance->less_hours));    
                                        } else {
                                            echo "-------";
                                        }
                                        
                                    ?>                                        
                                </td>
                                <td><?= $employeeAttendance->is_present == 1 ? __("Present")  : __("Absent") ?></td>
                                <td><?= h($employeeAttendance->hours_worked) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['action' => 'view', $employeeAttendance->id]) ?>
                                    <?php if ($optionAvail == true) { ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employeeAttendance->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employeeAttendance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeAttendance->id)]) ?>
                                    <?php } ?>
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

