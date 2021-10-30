<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\I18n\Time;

/**
 * EmpLeaves Controller
 *
 * @property \App\Model\Table\EmpLeavesTable $EmpLeaves
 *
 * @method \App\Model\Entity\EmpLeave[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SendEmailAtASpecificTimeController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function main()
    {
        $this->autoRender = false;

        $this->loadModel('Employees');
        $this->loadModel('EmpLeaves');

        $nowTime = date('Y-m-d');
        $nowTime = date('Y-m-d', strtotime($nowTime));

        $previousTime = date('Y/m/d',strtotime("-1 days"));
        $previousTime = date('Y-m-d', strtotime($previousTime));

        // pending leave information from syl
        $totalLeavesFromSyl = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'SYL'])->toArray();
        $totalLeavesFromSylCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'SYL'])->count();

        // pending leave information from dhk
        $totalLeavesFromDhk = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'DHK'])->toArray();
        $totalLeavesFromDhkCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'DHK'])->count();

        // pending leave information from goa
        $totalLeavesFromGoa = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'GOA'])->toArray();
        $totalLeavesFromGoaCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'GOA'])->count();

        // pending leave information from nyc
        $totalLeavesFromNyc = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'NYC'])->toArray();
        $totalLeavesFromNycCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'NYC'])->count();

        // pending leave information from nyc
        $totalLeavesFromUkr = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'UKR'])->toArray();
        $totalLeavesFromUkrCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$nowTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'UKR'])->count();

        $applierEmail = $this->Auth->user('office_email');
        $applierName  = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

        $emailTo = array();
        $emailTo[] = 'bahlul.siddiquee@sjinnovation.com';
        
        $email = new Email();
        $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
            ->setto($emailTo)
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
                    'totalLeavesFromUkrCount' => $totalLeavesFromUkrCount
                ])
            ->send();

        // pending leave information from syl
        $totalLeavesFromSyl = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'SYL'])->toArray();
        $totalLeavesFromSylCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'SYL'])->count();

        // pending leave information from dhk
        $totalLeavesFromDhk = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'DHK'])->toArray();
        $totalLeavesFromDhkCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'DHK'])->count();

        // pending leave information from goa
        $totalLeavesFromGoa = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'GOA'])->toArray();
        $totalLeavesFromGoaCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'GOA'])->count();

        // pending leave information from nyc
        $totalLeavesFromNyc = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'NYC'])->toArray();
        $totalLeavesFromNycCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'NYC'])->count();

        // pending leave information from nyc
        $totalLeavesFromUkr = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'UKR'])->toArray();
        $totalLeavesFromUkrCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' =>$previousTime])->where(['is_approved' => 0])->contain(['Employees'])->where(['Employees.office_location'=>'UKR'])->count();

        if($totalLeavesFromSylCount != 0 || $totalLeavesFromDhkCount != 0 || $totalLeavesFromGoaCount != 0
            || $totalLeavesFromNycCount != 0 || $totalLeavesFromUkrCount != 0) {
            $todaysallLeaveCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' => $previousTime])->contain(['Employees'])->WHERE(['is_approved' => 0])->toArray();

            $totalLeaveDaysCount = $this->EmpLeaves->find('all')->WHERE(['EmpLeaves.created' => $previousTime])
                ->contain(['Employees'])->WHERE(['is_approved' => 0])->count();

            $applierEmail = $this->Auth->user('office_email');
            $applierName = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');

            $emailTo = array();
            $emailTo[] = 'bahlul.siddiquee@sjinnovation.com';
            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                ->setto($emailTo)
                ->setemailFormat('html')
                ->setTemplate('email_at_once_yesterday')
                ->setsubject("Yesterday's all applied leave request #" . rand(108512, 709651))
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
                        'totalLeavesFromUkrCount' => $totalLeavesFromUkrCount
                    ])
                ->send();
        }

        $this->set(compact('totalLeavesFromSyl','totalLeavesFromSylCount', 'totalLeavesFromDhk', 'totalLeavesFromDhkCount', 'totalLeavesFromGoa', 'totalLeavesFromGoaCount', 'totalLeavesFromNyc', 'totalLeavesFromNycCount', 'totalLeavesFromUkr', 'totalLeavesFromUkrCount'));
    }
}