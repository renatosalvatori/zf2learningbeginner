<?php
namespace Application\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\SessionManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;

class SessionService implements FactoryInterface{
	
	const CONTAINER ='session_application';
	
	public function createService(ServiceLocatorInterface $serviceLocator){
		$config = $serviceLocator->get('session_config_application');
		if(isset($config['container'])){
			$container = $config['container'];
		}
		else 
			$container = self::CONTAINER;

		return new Container(self::CONTAINER);
	}

}
?>