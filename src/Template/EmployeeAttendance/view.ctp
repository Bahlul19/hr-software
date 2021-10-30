<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeAttendance $employeeAttendance
 */
?>
<div class="row designation">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">View Attendance</h4>
            </div>
            <div class="card-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="control-label">Attendance Detail: </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($employeeAttendance)){ ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label">Shift: </label>
                                <?= h($employeeAttendance->shift) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= __('Date') ?>: </label>
                                <?= h($employeeAttendance->date) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label"><?= __('Checkin') ?>: </label>
                                <?= h($employeeAttendance->checkin) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label"><?= __('Checkout') ?>: </label>
                                <?= h($employeeAttendance->checkout) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label"><?= __('Ot Hours') ?>: </label>
                                <?= h($employeeAttendance->extra_hours) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label"><?= __('Created') ?>: </label>
                                <?= h($employeeAttendance->created) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label"><?= __('Modified') ?>: </label>
                                <?= h($employeeAttendance->modified) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label class="control-label"><?= __('Is Present') ?>: </label>
                                <?= $employeeAttendance->is_present ? __('Yes') : __('No'); ?>
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="row">
                            <div class="col-md-6" >
                                <h4>Record does not exist. please check</h4>
                            </div>
                        </div>
                  <?php } ?>
                    <div class="form-actions">
                        <?php
                            echo $this->Html->link(
                                __('Back'),
                                ['action' => 'index'], ['class' => 'btn btn-inverse']
                            );
                        ?>
                    </div>
            </div>
        </div>
    </div>
</div>
