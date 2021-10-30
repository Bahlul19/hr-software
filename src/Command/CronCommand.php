<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Mailer\Email;

/**
 * EmpLeaves Controller
 *
 * @property \App\Model\Table\EmpLeavesTable $EmpLeaves
 *
 * @method \App\Model\Entity\EmpLeave[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class CronCommand extends Command
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        //$io->out('Hello world.');
        $nowTime = date('Y-m-d');
        $nowTime = date('Y-m-d', strtotime($nowTime));

        $previousTime = date('Y/m/d',strtotime("-1 days"));
        $previousTime = date('Y-m-d', strtotime($previousTime));

        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');

            // pending leave information from goa 
            $totalLeavesFromGoa =  $this->EmpLeaves->find()->select($this->EmpLeaves)->select([ 
                               'min_date' => 'min(date_from)',
                               'max_date' => 'max(date_to)'])
                       ->WHERE(['date(EmpLeaves.created)' =>$nowTime,'is_approved' => 0,'Employees.office_location'=>'GOA'])
                       ->contain(['Employees'])
                       ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                       ->toArray();

            $totalLeavesFromGoaCount = $this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$nowTime])->where(['is_approved' => 0,'Employees.office_location'=>'GOA'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->contain(['Employees'])->count();
            
            // pending leave information from syl 
            $totalLeavesFromSyl= $this->EmpLeaves->find()->select($this->EmpLeaves)->select([
                                        'min_date' => 'min(date_from)',
                                        'max_date' => 'max(date_to)' ])
                       ->WHERE(['date(EmpLeaves.created)' =>$nowTime])
                       ->where(['is_approved' => 0])
                       ->contain(['Employees'])
                       ->where(['Employees.office_location'=>'SYL'])
                       ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                       ->toArray();
            
            $totalLeavesFromSylCount=$this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$nowTime])->where(['is_approved' => 0,'Employees.office_location'=>'SYL'])->contain(['Employees'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->count();
            
            // pending leave information from dhk
            $totalLeavesFromDhk = $this->EmpLeaves->find()->select($this->EmpLeaves)->select([
                                    'min_date' => 'min(date_from)',
                                    'max_date' => 'max(date_to)' ])
                        ->WHERE(['date(EmpLeaves.created)' =>$nowTime,'Employees.office_location'=>'DHK','is_approved' => 0])
                        ->contain(['Employees'])
                        ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                        ->toArray();
            
            $totalLeavesFromDhkCount = $this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$nowTime,'is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'DHK'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->count();
            
            // pending leave information from nyc
            $totalLeavesFromNyc = $this->EmpLeaves->find()->select($this->EmpLeaves)->select([
                                        'min_date' => 'min(date_from)',
                                        'max_date' => 'max(date_to)' ])
                         ->WHERE(['date(EmpLeaves.created)' =>$nowTime])
                         ->where(['is_approved' => 0])
                         ->contain(['Employees'])
                         ->where(['Employees.office_location'=>'NYC'])
                         ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                         ->toArray();
            
            $totalLeavesFromNycCount = $this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'NYC'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->count();
            
            // pending leave information from ukr
            $totalLeavesFromUkr = $this->EmpLeaves->find()->select($this->EmpLeaves)->select([
                                   'min_date' => 'min(date_from)',
                                'max_date' => 'max(date_to)' ])
                        ->WHERE(['date(EmpLeaves.created)' =>$nowTime])
                        ->where(['is_approved' => 0])
                        ->contain(['Employees'])
                        ->where(['Employees.office_location'=>'UKR'])
                        ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                        ->toArray();
            
            $totalLeavesFromUkrCount = $this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'UKR'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->count();
            
            //yesterday's leave request
            //pending leave information from syl
            $totalLeavesFromSylYesterday = $this->EmpLeaves->find()->select($this->EmpLeaves)->select([
                                            'min_date' => 'min(date_from)',
                                            'max_date' => 'max(date_to)' ])
                                    ->WHERE(['date(EmpLeaves.created)' =>$previousTime])
                                    ->where(['is_approved' => 0])
                                    ->contain(['Employees'])
                                    ->where(['Employees.office_location'=>'SYL'])
                                    ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                                    ->toArray();
            
            $totalLeavesFromSylCountYesterday = $this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'SYL'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->count();
            
            // pending leave information from dhk
            $totalLeavesFromDhkYesterday = $this->EmpLeaves->find()->select($this->EmpLeaves)->select([
                                   'min_date' => 'min(date_from)',
                                'max_date' => 'max(date_to)' ])
                                    ->WHERE(['date(EmpLeaves.created)' =>$previousTime])
                                    ->where(['is_approved' => 0])
                                    ->contain(['Employees'])
                                    ->where(['Employees.office_location'=>'DHK'])
                                    ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                                    ->toArray();
            
            $totalLeavesFromDhkCountYesterday = $this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'DHK'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->count();
            
            // pending leave information from goa
            $totalLeavesFromGoaYesterday = $this->EmpLeaves->find()->select($this->EmpLeaves)->select([
                                                        'min_date' => 'min(date_from)',
                                                         'max_date' => 'max(date_to)' ])
                                    ->WHERE(['date(EmpLeaves.created)' =>$previousTime])
                                    ->where(['is_approved' => 0])
                                    ->contain(['Employees'])
                                    ->where(['Employees.office_location'=>'GOA'])
                                    ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                                    ->toArray();
            
            $totalLeavesFromGoaCountYesterday = $this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'GOA'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->count();
            
            // pending leave information from nyc
            $totalLeavesFromNycYesterday = $this->EmpLeaves->find()->select($this->EmpLeaves)->select([
                                             'min_date' => 'min(date_from)',
                                             'max_date' => 'max(date_to)' ])
                                    ->WHERE(['date(EmpLeaves.created)' =>$previousTime])
                                    ->where(['is_approved' => 0])
                                    ->contain(['Employees'])
                                    ->where(['Employees.office_location'=>'NYC'])
                                    ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                                    ->toArray();
                                    
                                    
            $totalLeavesFromNycCountYesterday = $this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'NYC'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->count();
            
            // pending leave information from nyc
            $totalLeavesFromUkrYesterday = $this->EmpLeaves->find()->select($this->EmpLeaves)->select([
                                            'min_date' => 'min(date_from)',
                                            'max_date' => 'max(date_to)' ])
                                    ->WHERE(['date(EmpLeaves.created)' =>$previousTime])
                                    ->where(['is_approved' => 0])
                                    ->contain(['Employees'])
                                    ->where(['Employees.office_location'=>'UKR'])
                                    ->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])
                                    ->toArray();
            
            $totalLeavesFromUkrCountYesterday = $this->EmpLeaves->find()->WHERE(['date(EmpLeaves.created)' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'UKR'])->group(['employee_id','leave_type','leave_reason','date(EmpLeaves.created)'])->count();

            $emailTo = array();
            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                 ->setto($emailTo)
                // ->setCc('hr@managedcoder.com')
                ->setemailFormat('html')
                ->setTemplate('email_at_once')
                ->setsubject("Today's all applied leave request #" . rand(108512, 709651))
                ->setViewVars(
                    [
                        'totalLeavesFromSyl' => $totalLeavesFromSyl,
                        'totalLeavesFromSylCount' => $totalLeavesFromSylCount,
                        'totalLeavesFromDhk' => $totalLeavesFromDhk,
                        'totalLeavesFromDhkCount' => $totalLeavesFromDhkCount,
                        'totalLeavesFromGoa' => $totalLeavesFromGoa,
                        'totalLeavesFromGoaCount' => $totalLeavesFromGoaCount,
                        'totalLeavesFromNyc' => $totalLeavesFromNyc,
                        'totalLeavesFromNycCount' => $totalLeavesFromNycCount,
                        'totalLeavesFromUkr' => $totalLeavesFromUkr,
                        'totalLeavesFromUkrCount' => $totalLeavesFromUkrCount,
    
                        'totalLeavesFromSylYesterday' => $totalLeavesFromSylYesterday,
                        'totalLeavesFromSylCountYesterday' => $totalLeavesFromSylCountYesterday,
                        'totalLeavesFromDhkYesterday' => $totalLeavesFromDhkYesterday,
                        'totalLeavesFromDhkCountYesterday' => $totalLeavesFromDhkCountYesterday,
                        'totalLeavesFromGoaYesterday' => $totalLeavesFromGoaYesterday,
                        'totalLeavesFromGoaCountYesterday' => $totalLeavesFromGoaCountYesterday,
                        'totalLeavesFromNycYesterday' => $totalLeavesFromNycYesterday,
                        'totalLeavesFromNycCountYesterday' => $totalLeavesFromNycCountYesterday,
                        'totalLeavesFromUkrYesterday' => $totalLeavesFromUkrYesterday,
                        'totalLeavesFromUkrCountYesterday' => $totalLeavesFromUkrCountYesterday
                    ])
                ->send();
    }
}