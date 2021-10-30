<div class="row">
    <div class="col-12 remove-padding">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?php echo "Add Daily Attendence Report"; ?></h4>
            </div>
            <div class="card-body wizard-content">
                <?php echo $this->Form->create('employeeAttendance', ['type' => 'file']); ?>
                      <input type="file" name="attendenceSheet" />
                      
                      <input type="submit" value="Submit" class="btn btn-primary">
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
