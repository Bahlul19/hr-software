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

class ProcessReviewThreeMonths extends Command
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('ProcessDocumentations');
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $reviewMonths=3;
        $this->loadModel('ProcessDocumentations');

        $processDocumentations =$this->ProcessDocumentations
                                 ->find('all')
                                 ->select($this->ProcessDocumentations)
                                 ->select(['months'=>'TIMESTAMPDIFF(MONTH,"'.date('Y-m-d h:i:s').'",ProcessDocumentations.modified)'])
                                 ->contain('Employees')
                                 ->having(['months <='=>$reviewMonths]);
            $emailTo = array();
            $email = new Email();
            $email->setfrom(['connect@sjinnovation.com' => 'SJ Connect'])
                ->setto($emailTo)
                ->setCc('hr@managedcoder.com')
                ->setemailFormat('html')
                ->setTemplate('email_for_process_review')
                ->setsubject("Today's all applied leave request #" . rand(108512, 709651))
                ->setViewVars(['processDocumentations' =>$processDocumentations])
                ->send();
    }
}