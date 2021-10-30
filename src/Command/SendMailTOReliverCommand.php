<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Mailer\Email;

class SendMailTOReliverCommand extends Command
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');
    }


    public function execute(Arguments $args, ConsoleIo $io)
    {
        $nowTime = date('Y-m-d');
        $tomorrow = date("Y-m-d", time() + 86400);
        $reliverFind = $this->EmpLeaves->find('all')->WHERE(['date_from' => $tomorrow,'is_approved'=>1])->contain(['Employees'])->toArray();
        foreach($reliverFind as $key => $reliver)
        {
            $reliverString = trim($reliver['reliever'],",");
            $reliverIds=explode(",",$reliverString);
            $results = $this->Employees->find('all')->where(['id IN' => $reliverIds])->toArray();
            $applierName= $reliver['employee_name'];
            $empName    = $reliver['employee_name'];
            $dateFrom   = $reliver['date_from'];
            $dateTo     = $reliver['date_to'];
            $no_of_days = $reliver['no_of_days'];
            $leaveType  = $this->EmpLeaves->getLeaveTypeByLeaveId($reliver['leave_type']);

            foreach($results as $index => $result)
            {
                $name=$result['first_name']." ".$result['last_name'];
                $emailTo["office_email"]=$name;
            }

            $io->out(print_r($emailTo,true));

            if($reliver)
            {
                $subject=$applierName . ' Application for reliver notification #' . rand(108512, 709651);
                $email = new Email();
                $email->setEmailFormat('html');
                $email->setTemplate('send_email_to_reliever_the_day_before');
                $email->setFrom(['connect@sjinnovation.com' => 'SJ Connect']);
                $email->setTo($emailTo);
                $email->setSubject($subject);
                $email->setViewVars( ['applierName' => $applierName,
                                      'first_name' => $empName,
                                      'date_from' => $dateFrom,
                                      'date_to' => $dateTo,
                                      'no_of_days' => $no_of_days,
                                      'leave_type' => $leaveType]);
                $email->send();
            }      
        } 
    }
}


?>