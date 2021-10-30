                                    
<?php if($empOffcLoc == "SYL" || $empOffcLoc == "DHK" || $empOffcLoc == "NYC"){ ?>
<div class="row">   
    <div class="col-md-3">
    <label for="">Sick Leave Taken &nbsp;&nbsp;&nbsp;</label>
        <div class="form-group">
            <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'sickTaken','value'=>$sick_taken,'readonly'=>'true']);
            ?>
        </div>
    </div>      
    <div class="col-md-3">
    <label for="">Rem. Sick Leave&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <div class="form-group">
            <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'sickRemaining','value'=>$remainingSickLeave,'readonly'=>'true']);
            ?>
        </div>
    </div>    
    <div class="col-md-3">
    <label for="">Casual Leave Taken</label>
        <div class="form-group">
            <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'casualTaken','readonly'=>'true','value' => $casual_taken]);
            ?>
        </div>
    </div>    
    <div class="col-md-3">
    <label for="">Rem. Casual Leave</label>
        <div class="form-group">
            <?php
            // if(!empty($remainingCasualLeave)){
                echo $this->Form->text('',['class' => 'form-control','id'=>'casualRemaining','readonly'=>'true','value'=>$remainingCasualLeave]);
            // } else {
            //     echo $this->Form->text('',['class' => 'form-control','readonly'=>'true','value'=>'Not Applicable']);
            // }
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label for="">Earned Leave Taken</label>
        <div class="form-group">
            <?php
            echo $this->Form->text('',['class' => 'form-control','id'=>'earnedTaken','readonly'=>'true','value' => $earned_taken]);
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <label for="">Rem. Earned Leave</label>
        <div class="form-group">
            <?php
            echo $this->Form->text('',['class' => 'form-control','id'=>'earnedRemaining','readonly'=>'true','value' => $remainingEarnedLeave]);
            ?>
        </div>
    </div>
    <div class="col-md-3">
    <label for="">LWoP Leave Taken</label>
        <div class="form-group">
            <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'lwopTaken','readonly'=>'true','value' => $LWoP_taken]);
            ?>
        </div>
    </div>    
    <div class="col-md-3">
    <label for="">Total Leave Taken&nbsp;&nbsp;&nbsp;   </label>
        <div class="form-group">
            <?php
                echo $this->Form->text('',['class' => 'form-control', 'id'=>'dayOffRemaining','readonly'=>'true','value' => $totalLeaveTaken]);
            ?>
        </div>
    </div>                                      
</div>
<?php } elseif ($empOffcLoc == "GOA") { ?>

    <div class="row">
        <div class="col-md-3">
            <label for="">Planned Leave Taken</label>
            <div class="form-group">
                <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'plannedTaken','readonly'=>'true','value' => $planned_taken]);
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <label for="">Rem. Planned Leave</label>
            <div class="form-group">
                <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'plannedRemaining','readonly'=>'true','value' => $remainingPlannedLeave]);
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <label for="">Un-Planned Leave Taken</label>
            <div class="form-group">
                <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'unplannedTaken','readonly'=>'true','value' => $unplanned_taken]);
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <label for="">Rem. Un-Planned Leave&nbsp;&nbsp;&nbsp;   </label>
            <div class="form-group">
                <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'unplannedRemaining','readonly'=>'true','value' => $remainingUnplannedLeave]);
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="">Restricted Holiday Taken</label>
            <div class="form-group">
                <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'restrictedTaken','readonly'=>'true','value' => $restricted_taken]);
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <label for="">Rem. Restricted H. Leave&nbsp;&nbsp;&nbsp;   </label>
            <div class="form-group">
                <?php
                echo $this->Form->text('',['class' => 'form-control','id'=>'restrictedRemaining','readonly'=>'true','value' => $remainingRestrictedLeave]);
                ?>
            </div>
        </div>
        <div class="col-md-3">
        <label for="">LWoP Leave Taken</label>
            <div class="form-group">
                <?php
                    echo $this->form->text('',['class' => 'form-control','readonly'=>'true','id'=>'lwopTaken','value' => $LWoP_taken]);
                ?>
            </div>
        </div> 
        <div class="col-md-3">
            <label for="">Total Leave Taken</label>
            <div class="form-group">
                <?php
                    echo $this->Form->text('', ['class' => 'form-control', 'readonly'=>'true','value'=>$totalLeaveTakenForGoa]);
                ?>
            </div>
        </div>
    </div>

<?php    } else {?>

    <div class="row">
        <div class="col-md-3">
            <label for="">Leave Taken</label>
            <div class="form-group">
                <?php
                echo $this->Form->text('', ['class' => 'form-control', 'id'=>'dayOffTaken', 'readonly'=>'true','value'=>$dayOffTaken]);
                ?>
            </div>
        </div>
        <div class="col-md-3">
        <label for="">LWoP Leave Taken</label>
            <div class="form-group">
                <?php
                    echo $this->form->text('',['class' => 'form-control','readonly'=>'true','id'=>'lwopTaken','value' => $LWoP_taken]);
                ?>
            </div>
        </div> 
        <div class="col-md-6">
            <label for="">Remaining Leave</label>
            <div class="form-group">
                <?php
                echo $this->Form->text('', ['class' => 'form-control', 'id'=>'dayOffRemaining', 'readonly'=>'true','value'=>$remainingDayOffLeave]);
                ?>
            </div>
        </div>
    </div>

<?php } ?>