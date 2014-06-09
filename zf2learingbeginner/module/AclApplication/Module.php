<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/AclApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace AclApplication;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Acl;

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

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $em = $e->getApplication()->getEventManager();
        $em->attach('route', array($this, 'ProtectPage'), -100);
    }
    
    
    public function ProtectPage(\Zend\EventManager\EventInterface $e) { // Event manager of the app
    	$application = $e->getApplication();
    	$routeMatch = $e->getRouteMatch();
    	$sm = $application->getServiceManager();
    	$auth = $sm->get('AuthService');
    	$acl = $sm->get('acl');
    	// everyone is guest until logging in
    	$role = $acl::DEFAULT_ROLE; // The default role is guest $acl
    
    	$controller = $routeMatch->getParam('controller');
    	$action = $routeMatch->getParam('action');
    
    	// check controller senza redirect
    	$array_controller = array("AuthApplication\Controller\RegisterController","Application\Controller\Index");
    	if(!$auth->hasIdentity() && !in_array($controller,$array_controller)){
    		$routeMatch->setParam('controller', 'AuthApplication\Controller\Login');
    		$routeMatch->setParam('action', 'login');
    	}
    	else{
    		if($auth->hasIdentity()){
    			$user = $auth->getIdentity();
    			$role = $user->ROLE;
    		}
    
    		//echo "$role, $controller, $action <br />";
    		//die();
    
    		if (!$acl->hasResource($controller)) {
    			throw new \Exception('Resource ' . $controller . ' not defined');
    		}
    
    		
    		if (!$acl->isAllowed($role, $controller, $action)) {
    			 
    			$response = $e->getResponse();
    			$config = $sm->get('config');
    			$redirect_route = $config['acl']['redirect_route'];
    			if(!empty($redirect_route)) {
    				$url = $e->getRouter()->assemble($redirect_route['params'], $redirect_route['options']);
    				$response->getHeaders()->addHeaderLine('Location', $url);
    				// The HTTP response status code 302 Found is a common way of performing a redirection.
    				// http://en.wikipedia.org/wiki/HTTP_302
    				$response->setStatusCode(302);
    				$response->sendHeaders();
    				exit;
    			} else {
    				//Status code 403 responses are the result of the web server being configured to deny access,
    				//for some reason, to the requested resource by the client.
    				//http://en.wikipedia.org/wiki/HTTP_403
    				$response->setStatusCode(403);
    				$response->setContent('
                    <html>
                        <head>
                            <title>403 Forbidden</title>
                        </head>
                        <body>
                            <h1>403 Forbidden</h1>
                        </body>
                    </html>'
    				);
    				return $response;
    			}
    		}
    
    	}
    
    }
}
