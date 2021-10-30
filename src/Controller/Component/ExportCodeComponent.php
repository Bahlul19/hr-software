<?php

namespace App\Controller\Component;

use App\Model\Table\EmpLeavesTable;
use Cake\Controller\Component;
use Cake\Core\Configure;

class ExportCodeComponent extends Component
{
    function exportExcelReport($leaves) {
        $table = '';
        $table = '<table cellspacing="2" cellpadding="5" style="border:2px;text-align:center;" border="1" width="100%" ';
        $table .= '<tr>
                <th style="text-align: left"> Employee </th>
                <th style="text-align: left"> Leave Type </th>
                <th style="text-align: center"> Date From </th>
                <th style="text-align: center"> Date To </th>
                <th style="text-align: center"> Approved/Rejected </th>
                <th style="text-align: center"> No. Of Days </th>
                <th style="text-align: center"> Half Day </th>
                <th style="text-align: left"> Reliever </th>
                <th style="text-align: left"> Status </th>
                </tr>';

        foreach ($leaves as $leave) {
            if(h($leave->leave_type) == 1){
                $leaveType="Sick Leave";
            } elseif(h($leave->leave_type) == 2){
                $leaveType="Casual Leave";
            } elseif(h($leave->leave_type) == 3){
                $leaveType="LWoP Leave";
            } elseif(h($leave->leave_type) == 5){
                $leaveType="Un-Planned Leave";
            }  elseif(h($leave->leave_type) == 6){
                $leaveType="Planned Leave";
            } elseif(h($leave->leave_type) == 7){
                $leaveType="Restricted Leave";
            }  elseif(h($leave->leave_type) == 8){
                $leaveType="Day Off";
            }  else {
                $leave="Earned Leave";
            }

            if($leave->half_day == 1){
                $days = "First Half";
            } elseif($leave->half_day == 2){
                $days = "Second Half";
            } else {
                $days = "-";
            }

            if($leave->is_approved == 0){
                $status = "Pending";
            } elseif ($leave->is_approved == 1){
                $status = "Approved";
            } elseif($leave->is_approved == 2) {
                $status = "Rejected";
            } else {
                $status = "Cancelled";
            }

            $finalReliever = $leave->reliever_name;

            $table .= '<tr>
                <td style="text-align: left">' . $leave->employee->first_name . ' ' . $leave->employee->last_name . '</td>
                <td style="text-align: left">' . $leaveType . '</td>
                <td style="text-align: center">' . date('m/d/Y', strtotime(h($leave->date_from))) . '</td>
                <td style="text-align: center">' . date('m/d/Y', strtotime(h($leave->date_to))) . '</td>
                <td style="text-align: center">' . date('m/d/Y', strtotime(h($leave->modified))) . '</td>
                <td style="text-align: center">' . $leave->no_of_days . '</td>
                <td style="text-align: center">' . $days . '</td>
                <td style="text-align: left">' . h($finalReliever) . '</td>
                <td style="text-align: left">' . $status . '</td>
                </tr>';
        }
        $table .= '</table>';
        header('Content-Type: application/force-download');
        header('Content-disposition: attachment;filename = ' . date('YmdHis') . '.xls');
        header("Pragma: ");
        header("Cache-Control: ");
        echo $table;
    }

    function exportCsvReport($leaves) {
        $table = '';
        $table .= 'Employee|Leave Type|Date From|Date To|Approved/Rejected|No. Of Days|Half Day|Reliever|Status';
        $table .= "\n";

        foreach ($leaves as $leave) {
            if(h($leave->leave_type) == 1){
                $leaveType="Sick Leave";
            } elseif(h($leave->leave_type) == 2){
                $leaveType="Casual Leave";
            } elseif(h($leave->leave_type) == 3){
                $leaveType="LWoP Leave";
            } elseif(h($leave->leave_type) == 5){
                $leaveType="Un-Planned Leave";
            }  elseif(h($leave->leave_type) == 6){
                $leaveType="Planned Leave";
            } elseif(h($leave->leave_type) == 7){
                $leaveType="Restricted Leave";
            }  elseif(h($leave->leave_type) == 8){
                $leaveType="Day Off";
            }  else {
                $leaveType="Earned Leave";
            }

            if($leave->half_day == 1){
                $days = "First Half";
            } elseif($leave->half_day == 2){
                $days = "Second Half";
            } else {
                $days = "-";
            }

            if($leave->is_approved == 0){
                $status = "Pending";
            } elseif ($leave->is_approved == 1){
                $status = "Approved";
            } elseif($leave->is_approved == 2) {
                $status = "Rejected";
            } else {
                $status = "Cancelled";
            }

            $table .= $leave->employee->first_name . ' ' . $leave->employee->last_name . '|' . $leaveType . '|' . date('m/d/Y', strtotime(h($leave->date_from))) . '|' . date('m/d/Y', strtotime(h($leave->date_to))) . '|' . date('m/d/Y', strtotime(h($leave->modified))) . '|' . $leave->no_of_days . '|' . $days . '|' . h($leave->reliever_name) . '|' . $status . '';
            $table .= "\n";
        }
        header('Content-Type: application/text');
        header('Content-disposition: attachment;filename = ' . date('YmdHis') . '.csv');
        header("Pragma: ");
        header("Cache-Control: ");
        echo $table;
    }
}