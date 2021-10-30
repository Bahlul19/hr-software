<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HubstuffHour $hubstuffHour
 */
?>

<div class="hubstuffHours form large-9 medium-8 columns content">
    <?= $this->Form->create($hubstaffHour,['id'=>'editHubStaff']) ?>
    <br>
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white"><?= __('Edit Hubstuff Hour') ?></h4>
        </div>
    <div class="card-body wizard-content">
            <div class="row">
                    <div class='col-lg-12'>
                        <div class="row">
                            <div class="col-lg-10">
                            </div>
                            <div class="col-lg-10">
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" id="date" class='form-control' value="<?php echo date("Y-m-d",strtotime($hubstaffHour['date'])); ?>" />
                            <?php //echo $this->Form->control('date', ['empty' => true,'class'=>'form-control']); 
                            ?>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                        <label>Time</label>
                        <input type="time" name="time" id="time" class='form-control' value="<?php echo date("H:i:s",strtotime($hubstaffHour['time'])); ?>" />
                        <?php //echo $this->Form->control('time', ['empty' => true,'class'=>'form-control','readonly'=>'true']); 
                        ?>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <?php echo $this->Form->control('member' ,['class'=>'form-control','readonly'=>'true']); ?>
                        </div>   
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <label>Task Id</label>
                            <input type='text' name="task_id" class='form-control' readonly='true' value="<?= $hubstaffHour['task_id'] ?>" />
                            <?php //echo $this->Form->control('task_id' ,['class'=>'form-control','readonly'=>'true']); ?>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <?php echo $this->Form->control('task' ,['class'=>'form-control','readonly'=>'true']); ?>
                        </div>   
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <?php echo $this->Form->control('project' ,['class'=>'form-control','readonly'=>'true']); ?>
                        </div>   
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <?php echo $this->Form->control('activity' ,['class'=>'form-control','readonly'=>'true']); ?>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <?php echo $this->Form->control('spent' ,['class'=>'form-control','readonly'=>'true']); ?>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <?php  echo $this->Form->control('notes' ,['class'=>'form-control','readonly'=>'true']); ?>
                        </div>
                    </div>
                </div>
                <?php
                    echo $this->Form->button(
                    'Save', [
                        'type' => 'submit',
                        'class' => 'btn btn-info right-align',
                        'id'=>'hubstaffEdit',
                        'templates' => [
                            'inputContainer' => '{{content}}'
                        ],
                        'data-toggle' => 'tooltip',
                        'data-original-title' => 'save'
                    ]); 
                ?>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
