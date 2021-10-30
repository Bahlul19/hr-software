<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Controller\Component\AuthComponent;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $components = array('RequestHandler');
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('ExportCode');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
                'loginRedirect'=>[
                    'controller'=>'Employees',
                    'action'    =>'dashboard'
                ],
                'authError' => 'Your session has timed out.',
                'authenticate' =>[
                    'Form' => [
                        'fields' => ['username' => 'office_email', 'password' => 'password'],
                        'userModel' => 'Employees'                           
                    ]
                ],
                'loginAction' => [
                    'controller'=>'Employees',
                    'action'    =>'login'
                ],
                'logoutRedirect'=>[
                   'controller'=>'Employees',
                   'action'    =>'login'
                ]
            ]
        );
        $this->Auth->allow(['updateUsingCronJob', 'forgot', 'retrieve','leaveRequestCategorizedViaLocation']);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        $loggedUser = 0;
        if ($this->request->getSession()->read('Auth.User')) {
            $loggedUser = $this->request->getSession()->read('Auth.User');
        }
        $this->set(compact("loggedUser"));
        $this->loadComponent('Auth');
        if($this->Auth->user())
        {
            $user = $this->Auth->user();
            $uid = $this->Auth->user('id');
            $this->loadModel('Employees');
            $query = $this->Employees->find('all')->where(['id' => $uid])->toArray();
            $profile_pic = $query[0]->profile_pic;
            $this->request->getSession()->write('profile_pic',$profile_pic);      
        }
    }
}
