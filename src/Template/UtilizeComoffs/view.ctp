<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompOff $compOff
 */
?>
<div class="row leave-request">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">View Utilize Request of CompOff</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Name :</label>
                            <?= $this->Html->link($utilizeComoff->employee_name, ['controller' => 'Employees', 'action' => 'view', $utilizeComoff->employee_id])?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Request of utilize hours: </label>
                            <?php
                            echo $utilizeComoff->utilize_hours;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php if ($utilizeComoff->status == 0): ?>
                                <label class="control-label">Status:</label>
                                <?php
                                echo "Pending";
                                ?>
                            <?php endif; ?>
                            <?php if ($utilizeComoff->status == 1): ?>
                                <label class="control-label">Status:</label>
                                <?php
                                echo "Approved";
                                ?>
                            <?php endif; ?>
                            <?php if($utilizeComoff->status == 2): ?>
                                <label class="control-label">Status:</label>
                                <?php
                                echo "Rejected";
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Approved By:</label>
                            <?php
                            echo $utilizeComoff->approved_by;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Date:</label>
                            <?php
                            echo $utilizeComoff->date;
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" style="font-weight: bold; font-size: 22px"><?=$utilizeComoff->employee_name?>'s remaining CompOff approved hour:&nbsp;&nbsp;</label>
                            <?php
                            echo "<h3 style='display: inline-block; font-weight: bold'>".$compOffApprovedSum." hours</h3>";
                            ?>
                        </div>
                    </div>
                </div>
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


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Reject Reeason:</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <?php echo $this->Form->create($leaveRequest, ['url' => ['action' => 'rejectReason',2,$leaveRequest->id,$leaveRequest->employee_id,$leaveRequest->leave_type,$leaveRequest->half_day]]) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->control(
                                        'reject_reason', [
                                            'label' => [
                                                'class' => 'control-label'
                                            ],
                                            'class' => 'form-control'
                                        ]
                                    );

                                    echo $this->Form->text(
                                        'is_approved', [
                                            'class' => 'form-control',
                                            'value' => 2,
                                            'hidden'=>'true'
                                        ]
                                    );

                                    echo $this->Form->text(
                                        'approved_by', [
                                            'class' => 'form-control',
                                            'value' => 2,
                                            'hidden'=>'true',
                                            'value' => $userName
                                        ]
                                    );
                                    echo $this->Form->text(
                                        'date_from', [
                                            'class' => 'form-control',
                                            'hidden'=>'true',
                                            'value' => date_format(date_create($leaveRequest->date_from), 'Y-m-d H:i:s')
                                        ]
                                    );
                                    echo $this->Form->text(
                                        'date_to', [
                                            'class' => 'form-control',
                                            'hidden'=>'true',
                                            'value' => date_format(date_create($leaveRequest->date_to), 'Y-m-d H:i:s')
                                        ]
                                    );
                                    echo $this->Form->text(
                                        'leave_reason', [
                                            'class' => 'form-control',
                                            'hidden'=>'true',
                                            'value' => $leaveRequest->leave_reason
                                        ]
                                    );
                                    echo $this->Form->text(
                                        'reliever', [
                                            'class' => 'form-control',
                                            'hidden'=>'true',
                                            'value' => $leaveRequest->reliever
                                        ]
                                    );
                                    echo $this->Form->text(
                                        'applicant', [
                                            'class' => 'form-control',
                                            'hidden'=>'true',
                                            'value' => $leaveRequest->employee_id
                                        ]
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->Form->button(__('Submit'), ['type' => 'submit','class' => 'btn btn-danger mr-1']); ?>
                    <?php echo $this->Form->end() ?>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
