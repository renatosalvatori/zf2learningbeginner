<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/AclNavApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace AclNavApplication;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'setAclMenuNavigation'), -120);
    }
    
    
    public function setAclMenuNavigation(MvcEvent $event)
    {
    	$services = $event->getApplication()->getServiceManager();
    	$config = $services->get('config');
    
    	$auth     = $services->get('AuthService');
    	$acl      = $services->get('acl');
    	 
    	if ($auth->hasIdentity()) {
    		$user = $auth->getIdentity();
    		$role = $user->ROLE;
    	}
    	else
    		$role = \AclApplication\Acl\Acl::DEFAULT_ROLE; // The default role is guest $acl
    	
    	
    	 
    	\Zend\View\Helper\Navigation\AbstractHelper::setDefaultAcl($acl);
    	\Zend\View\Helper\Navigation\AbstractHelper::setDefaultRole($role);
    	 
    }
}
