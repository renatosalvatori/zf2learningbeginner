<?php
namespace AuthApplication\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AuthApplication\Controller\LoginController;
use AuthApplication\Form\LoginForm as Login;
use AuthApplication\Form\LoginFilter as LoginFilter; 

class LoginControllerFactory extends FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm){
        $service_manager = $sm->getServiceLocator();
        $controller = new \Application\Controller\LoginController();
        $controller->setAuthService($service_manager->get('AuthService'));
        return $controller;
        
    }
    
}

?>