<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeAttendance $employeeAttendance
 */
?>
<div class="employeeAttendance form large-9 medium-8 columns content">
    <?= $this->Form->create($employeeAttendance) ?>
    <fieldset>
        <legend><?= __('Edit Employee Attendance') ?></legend>
       <div class="row">
            <div class='col-lg-12'>
                 <div class="row">
                     <div class="col-lg-10">
                            <?= "Name :".$employeeAttendance['employee_name'] ?>
                            <br>
                     </div>
                     <div class="col-lg-10">
                            <label>Shift time </label>
                            <?php echo  date("h:i",strtotime($employeeAttendance['shift_start_at']))." to ".date("h:i",strtotime($employeeAttendance['shift_end_at'])); ?>
                     </div>
                 </div>
            </div>
            <div class='col-md-6'>  
                <div class="form-group">
                    <?= $this->Form->control('shift',['class'=>'form-control','disabled'=>['disabled']]); ?>
                </div>
            </div>
            <div class='col-md-6'>
                 <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" id="date" class='form-control'  value="<?php echo date("Y-m-d",strtotime($employeeAttendance['date'])); ?>" disabled='disabled' />
                 </div>   
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <label>Checkin</label>
                    <input type="time" name="checkin" id="checkin"   class='form-control' value="<?php echo date("H:i:s",strtotime($employeeAttendance['checkin'])); ?>" />
                </div>
            </div>
            <div class='col-md-6'>
                 <div class="form-group">
                    <label>Checkout</label>
                    <input type="time" name="checkout" id="checkout"  class='form-control without_ampm' value="<?php echo date("H:i:s",strtotime($employeeAttendance['checkout'])); ?>" />
                 </div>   
            </div>
            <div class='col-md-6'>
                 <div class="form-group">
                    <label>Hours Worked</label>
                    <input type="time" name="hours_worked" id="hours_worked" class='form-control without_ampm' value="<?php echo date("H:i:s",strtotime($employeeAttendance['hours_worked'])); ?>" disabled='disabled' />
                 </div>   
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <label>Ot Hours</label>
                    <input type="time" name="extra_hours" id="extra_hours" class='form-control without_ampm' value="<?php echo date("H:i:s",strtotime($employeeAttendance['extra_hours']));  ?>"  disabled='disabled'/>
                </div>
            </div>
            
            <div class='col-md-6'>
                 <div class="form-group">
                    <label>Early By</label>
                        <input type="time" name="early_by" id="early_by" class='form-control without_ampm' value="<?php echo date("H:i:s",strtotime($employeeAttendance['early_by'])); ?>" disabled='disabled' />
                 </div>   
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <label>Late By</label>
                    <input type="time" name="late_by" id="late_by" class='form-control without_ampm' value="<?php echo date("H:i:s",strtotime($employeeAttendance['late_by'])); ?>" disabled='disabled' />
                </div>
            </div>
        </div>
    </fieldset>
        <?php
             echo $this->Form->button(
             'Save', [
                 'type' => 'submit',
                 'class' => 'btn btn-info right-align',
                 'id'=>'attendenceSearch',
                 'templates' => [
                     'inputContainer' => '{{content}}'
                 ],
                 'data-toggle' => 'tooltip',
                 'data-original-title' => 'save'
             ]); 
        ?>

    <?= $this->Form->end() ?>
</div>
