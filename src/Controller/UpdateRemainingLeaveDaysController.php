<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class UpdateRemainingLeaveDaysController extends AppController
{
    public function updateUsingCronJob(){
        $leaveDaysTaken = TableRegistry::get('LeaveRequests');
        $LeaveDaysTaken = $leaveDaysTaken->find('all')->toArray();

        $leaveDays = TableRegistry::get('LeaveDays');
        $LeaveDays =  $leaveDays->find('all')->toArray();

        $employee = TableRegistry::get('Employees');
        $intern   = $employee->find('list')->WHERE(['employment_type'=>'intern'])->WHERE(['OR'=>[['office_location'=>'Sylhet'],['office_location'=>'Dhaka'],['office_location'=>'New York']]])->toArray();
        $goaMembers = $employee->find('all')->WHERE(['office_location'=>'Goa']);
        $ukraineMembers = $employee->find('all')->WHERE(['office_location'=>'Ukraine']);
        $SylDhkNYMebmers = $employee->find('all')->WHERE(['OR'=>[['office_location'=>'Sylhet'],['office_location'=>'Dhaka'],['office_location'=>'New York']]])->toArray();

        /*For Updating remainging leave days yearly for sylhet dhaka and new york office*/

        foreach ($LeaveDays as $lDays){
            $id = $lDays['id'];
            $employeeId = $lDays['employee_id'];

            //collecting sylhet dhaka new york intern members list.
            foreach($intern as $employee) {
                $internId[] = $employee;
            }
            //Collecting Goa Members list
            foreach($goaMembers as $GUM){
                $GUMid[] = $GUM['id'];
            }
            //Collecting Ukraine Members List
            foreach ($ukraineMembers as $UM){
                $UMid[] = $UM['id'];
            }
            //Collecting Sylhet Dhaka and New York Members list.
            foreach ($SylDhkNYMebmers as $SYD) {
                $SYDid [] = $SYD['id'];
            }

            if(!empty($internId)){
                if(in_array($employeeId, $internId)) {
                    $remainingDays = $leaveDays->get($id);
                    $remainingDays->sick_leave = $lDays['sick_leave'];
                    $remainingDays->casual_leave = 0.0;
                    $remainingDays->planned_leave= 0.0;
                    $remainingDays->unplanned_leave=0.0;

                    $update = $leaveDays->save($remainingDays);
                }
            }

//       if(!empty($GUMid)){
// //  Leave days according to goa policy  starts here
//                 if(in_array($employeeId, $GUMid)){
//                     $remainingDays = $leaveDays->get($id);

//                     $testing  = [];
//                     $year = 0;
//                     $month=0;
//                     $date = 0;

//                     $employeeDetails = $employee->find('all')->WHERE(['id' => $employeeId])->toArray();
//                     foreach ($employeeDetails as $ED) {
//                         $dateOfJoining = $ED['date_of_joining'];
//                     }
//                     $Presentdate = Time::now();
//                     $date = date_diff($Presentdate, $dateOfJoining);
//                     $year = $date->y;
//                     $month = $date->m;

//                     if ($year > 0 ){
//                         if ($year >= 5) {
//                             $remainingDays->planned_leave = 23.0;
//                         } else if ($year >= 4 && $year < 5) {
//                             $remainingDays->planned_leave = 21.0;
//                         } else if ($year >= 3 && $year < 4) {
//                             $remainingDays->planned_leave = 19.0;
//                         } else if ($year >= 2 && $year < 3) {
//                             $remainingDays->planned_leave = 17.0;
//                         } else if ($year >= 1 && $year < 2) {
//                             $remainingDays->planned_leave = 16.0;
//                         }
//                     }else {
//                         if($year == 0 || $year == null) {
//                             if ($month >= 6 && $month < 12) {
//                                 $remainingDays->planned_leave = 14.0;
//                             }
//                             if ($month < 6) {
//                                 $remainingDays->planned_leave = $remainingDays->planned_leave + 0;
//                             }
//                         }
//                     }

//                     $unplanned_leave = $remainingDays->unplanned_leave + 7.0;
//                     if($year > 0) {
//                         if ($unplanned_leave < 28) {
//                             $remainingDays->unplanned_leave = $unplanned_leave;
//                         } else {
//                             $remainingDays->unplanned_leave = 27.0;

//                         }
//                     }
//                     $remainingDays->restricted_leave = 3.0;
//                     $remainingDays->sick_leave = 0.0;
//                     $remainingDays->casual_leave = 0.0;
//                     $remainingDays->earned_leave = 0.0;
//                     $remainingDays->day_off      = 0.0;
//                     // $update = $leaveDays->save($remainingDays);
//                 }
//             }


//  Leave days for all offices other then goa office
            if (!empty($SYDid)) {
                if (in_array($employeeId, $SYDid)) {
                    $remainingDays = $leaveDays->get($id);

                    $updatedCasualLeave = $lDays['casual_leave'] + 7.0;
                    if ($updatedCasualLeave <= 12) {
                        $remainingDays->casual_leave = $updatedCasualLeave;
                    } else {
                        $remainingDays->casual_leave = 12.0;
                    }
                    $remainingDays->sick_leave = 7.0;

                    $remainingDays->earned_leave = 0.0;
                    $remainingDays->planned_leave = 0.0;
                    $remainingDays->unplanned_leave = 0.0;
                    $remainingDays->restricted_leave = 0.0;
                    $remainingDays->day_off          = 0.0;
                    //update function
                    $update = $leaveDays->save($remainingDays);
                }
            }
//  Leave days for Ukraine office
            if (!empty($UMid)) {
                if (in_array($employeeId, $UMid)) {
                    $remainingDays = $leaveDays->get($id);

                    $remainingDays->day_off = 18.0;
                    $remainingDays->sick_leave = 0.0;
                    $remainingDays->casual_leave= 0.0;
                    $remainingDays->earned_leave = 0.0;
                    $remainingDays->planned_leave = 0.0;
                    $remainingDays->unplanned_leave = 0.0;
                    $remainingDays->restricted_leave = 0.0;
                    //update function
                    $update = $leaveDays->save($remainingDays);
                }
            }

        }
        /* End For Updating remainging leave days yearly for sylhet dhaka and new york office*/

        /*Resetting taken leave days to 0 Days */
        foreach ( $LeaveDaysTaken as $ltDays) {
            $id = $ltDays['id'];
            $remainingDays = $leaveDaysTaken->get($id);
            $remainingDays->status = 0;

            $update =  $leaveDaysTaken->save($remainingDays);
        }
        die();
    }
}