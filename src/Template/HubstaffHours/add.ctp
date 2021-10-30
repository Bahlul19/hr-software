<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HubstaffHour $hubstuffHour
 */
?>
<div class="row">
    <div class="col-12 remove-padding">
    <br> 
    <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?php echo "Add Daily Hubstaff Attendence Report"; ?></h4>
            </div>
            <div class="card-body wizard-content">
                <?php echo $this->Form->create($HubstaffHours, ['type' => 'file','id'=>'UploadhubstaffCsv']); ?>
                      <input type="file" name="hubstaffHour"  accept=".csv" id="hubstaffAttendence" required/>
                      <input type="submit" value="Submit" class="btn btn-primary">
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

