<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/AuthApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace AuthApplication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        
        $auth = $this->getServiceLocator()->get('AuthService');
        if ($auth->hasIdentity()) {
        	$identity = $auth->getIdentity();
        }
      
        $userprofile = new ViewModel(
                    array("profile"=> $identity,
                          "successMessages" => $this->flashMessenger()->getCurrentSuccessMessages()
                            ));
        
        return $userprofile;
    }
    
    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /index/index/foo
        return array();
    }
}
