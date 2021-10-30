<label class="control-panel">Leave Type</label>
<?php
    if($employeeOfficeLocation == "SYL" || $employeeOfficeLocation == "DHK" || $employeeOfficeLocation == "NYC"){
        if ($employeeType == "intern"){
            echo $this->Form->select(
                'leave_type',[
                    '' => 'Select',
                    '1'=>'Sick Leave'
                ],['class'=>'form-control','id'=>'leaveType']
            );
        } else {
                echo $this->Form->select(
                'leave_type',[
                    '' => 'All Leaves',
                    '1'=>'Sick Leave',
                    '2'=>'Casual Leave',
                    '3'=>'LWoP Leave',
                    '4'=>'Earned Leave'
                ],['class'=>'form-control','id'=>'leaveType']
            );
        }
    } elseif ($employeeOfficeLocation == "GOA") {
        echo $this->Form->select(
            'leave_type',[
            '' => 'All Leaves',
            '3' => 'LWoP Leave',
            '5'=>'Un-Planned Leave',
            '6'=>'Planned Leave',
            '7'=>'Restricted Holiday'
        ],['class'=>'form-control','id'=>'leaveType']
        );
    } else {
        echo $this->Form->select(
            'leave_type',[
            '' => 'All Leaves',
            '3' => 'LWoP Leave',
            '8'=>'Day Off / vacation'
        ],['class'=>'form-control','id'=>'leaveType']
        );
    }
?>