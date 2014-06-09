<?php
return array(
	'service_manager' => array(
				'factories' => array(
						'acl' => function ($sm) {
							$config = $sm->get('config');
							if ($config['acl']['use_database_storage'])
								return new \AclApplication\Acl\AclDb($sm);
							else
								return new \AclApplication\Acl\Acl($config);
						}
				),
	),
    'controllers' => array(
        'invokables' => array(
            'AclApplication\Controller\Index' => 'AclApplication\Controller\IndexController',
        ),
    ),
	'view_helpers' => array(
				'factories' => array(
						'isAllowed' => function($sm) {
							$sm = $sm->getServiceLocator(); // $sm was the view helper's locator
							$auth = $sm->get('AuthService');
							$acl = $sm->get('acl');
		
							$helper = new \AclApplication\View\Helper\IsAllowed($auth, $acl);
							return $helper;
						}
				),
		),
	'controller_plugins' => array(
				'factories' => array(
						'isAllowed' => function($sm) {
							$sm = $sm->getServiceLocator(); // $sm was the view helper's locator
							$auth = $sm->get('AuthService');
							$acl = $sm->get('acl');
		
							$plugin = new \AclApplication\Controller\Plugin\IsAllowed($auth, $acl);
							return $plugin;
						}
				),
	),
    'router' => array(
        'routes' => array(
            'acl-application' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/index',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'AclApplication\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'AclApplication' => __DIR__ . '/../view',
        ),
    ),
);
