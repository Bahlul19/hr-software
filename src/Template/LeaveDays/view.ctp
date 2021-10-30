<div class="row designation">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">View Leave Days</h4>
            </div>
            <div class="card-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Sick Leave: </label>
                                <?php
                                    echo   $this->Number->format($leaveDay->sick_leave)
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Casual Leave: </label>
                                <?php
                                echo   $this->Number->format($leaveDay->casual_leave)
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Earned Leave: </label>
                            <?php
                            echo   $this->Number->format($leaveDay->earned_leave)
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Total Leave: </label>
                            <?php
                            $totalLeave = $leaveDay->sick_leave + $leaveDay->casual_leave + $leaveDay->earned_leave;
                            echo $this->Number->format($totalLeave)
                            ?>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Created By: </label>
                        <?php
                        echo $leaveDay->created_by;
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Updated By: </label>
                        <?php
                        echo $leaveDay->updated_by;
                        ?>
                    </div>
                </div>
            </div>
                <div class="form-actions">
                    <?php
                    echo $this->Html->link(
                        __('Back'),
                        ['controller'=>'employees','action' => 'index'], ['class' => 'btn btn-inverse']
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>