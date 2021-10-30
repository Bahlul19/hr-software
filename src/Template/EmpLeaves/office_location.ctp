<div class="form-group">
    <label class="control-panel">Leave Type</label>
<?php 
    echo $this->Form->control(
        'office_location', [
            'label' => [
                'class' => 'control-label'
            ],
            'class' => 'form-control',
            'value' => $empOffcLoc,
            'id' => 'officeLocation',
            'type'=>'hidden'
        ]
    );
?>   
    <?php
        if($empOffcLoc == "SYL" || $empOffcLoc == "DHK" || $empOffcLoc == "NYC"){
            if ($empType == "intern"){
                echo $this->Form->select(
                    'leave_type',[
                        '' => 'Select',
                        '1'=>'Sick Leave'
                    ],['class'=>'form-control','id'=>'leaveType', 'onchange' => 'return leaveTypeValidation("' . $empOffcLoc . '", "' . $remainingSickLeave . '", "' . $remainingCasualLeave . '", "' . $remainingEarnedLeave . '", "' . $remainingPlannedLeave . '", "' . $remainingUnplannedLeave . '", "' . $remainingRestrictedLeave . '")']
                );
            } else {
                    echo $this->Form->select(
                    'leave_type',[
                        '' => 'Select',
                        '1'=>'Sick Leave',
                        '2'=>'Casual Leave',
                        '3'=>'LWoP Leave',
                        '4'=>'Earned Leave'
                    ],['class'=>'form-control','id'=>'leaveType', 'onchange' => 'return leaveTypeValidation("' . $empOffcLoc . '", "' . $remainingSickLeave . '", "' . $remainingCasualLeave . '", "' . $remainingEarnedLeave . '", "' . $remainingPlannedLeave . '", "' . $remainingUnplannedLeave . '", "' . $remainingRestrictedLeave . '")']
                );
            }
        } elseif ($empOffcLoc == "GOA") {
            echo $this->Form->select(
                'leave_type',[
                '' => 'Select',
                '3'=>'LWoP Leave',
                '5'=>'Un-Planned Leave',
                '6'=>'Planned Leave',
                '7'=>'Restricted Holiday'
            ],['class'=>'form-control','id'=>'leaveType', 'onchange' => 'return leaveTypeValidation("' . $empOffcLoc . '", "' . $remainingSickLeave . '", "' . $remainingCasualLeave . '", "' . $remainingEarnedLeave . '", "' . $remainingPlannedLeave . '", "' . $remainingUnplannedLeave . '", "' . $remainingRestrictedLeave . '")']
            );
        } else {
            echo $this->Form->select(
                'leave_type',[
                '' => 'Select',
                '3'=>'LWoP Leave',
                '8'=>'Day Off / vacation'
            ],['class'=>'form-control','id'=>'leaveType', 'onchange' => 'return leaveTypeValidation("' . $empOffcLoc . '", "' . $remainingSickLeave . '", "' . $remainingCasualLeave . '", "' . $remainingEarnedLeave . '", "' . $remainingPlannedLeave . '", "' . $remainingUnplannedLeave . '", "' . $remainingRestrictedLeave . '")']
            );
        }
    ?>
</div>