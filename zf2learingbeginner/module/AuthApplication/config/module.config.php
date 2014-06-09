<?php
return array(
    'service_manager' =>array(
        'factories'=>array(
                'AuthService' => function($sm) {           
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$dbTableAuthAdapter = new Zend\Authentication\Adapter\DbTable($dbAdapter, 'USERS','USERNAME','PASSWORD', 'MD5(?)');
                	$authService = new Zend\Authentication\AuthenticationService();
                	$authService->setAdapter($dbTableAuthAdapter);
                	$authService->setStorage(new AuthApplication\Authentication\Storage\AuthStorage());
                	return $authService;
                },
         ),
         'invokables'=>array(),
         'aliases' => array('Zend\Authentication\AuthenticationService'=>'AuthService'),
         'shared' =>  array()
                
        
    ),
    'view_helpers' => array(
		'factories' => array(
    	)
    ),
    'controllers' => array(
        'invokables' => array(
            'AuthApplication\Controller\Index' => 'AuthApplication\Controller\IndexController',
            'AuthApplication\Controller\Login' => 'AuthApplication\Controller\LoginController',
        	'AuthApplication\Controller\Register' => 'AuthApplication\Controller\RegisterController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'auth-application' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/userprofile',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'AuthApplication\Controller',
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
                            'route'    => '/[:action]',
                            'constraints' => array(                   
                                'action'     => '[a-zA-Z]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'auth-login' => array(
            		'type' => 'Literal',
            		'options' => array(
            				'route' => '/login',
            				'defaults' => array(
            						'__NAMESPACE__' => 'AuthApplication\Controller',
            						'controller' => 'Login',
            						'action' => 'login',
            				),
            		),
            		'may_terminate' => true,
            		'child_routes' => array(
            				'process' => array(
            						'type' => 'Segment',
            						'options' => array(
            								'route' => '[/:action]',
            								'constraints' => array(        								
            										'action' => '[a-zA-Z]*',
            								),
            								'defaults' => array(
            								),
            						),
            				),
            		),
            ),
        	'auth-user' => array(
        		'type' => 'Literal',
        			'options' => array(
        					'route' => '/user',
        					'defaults' => array(
        							'__NAMESPACE__' => 'AuthApplication\Controller',
        							'controller' => 'Register',
        							'action' => 'register',
        					),
        			),
        			'may_terminate' => true,
        			'child_routes' => array(
        					'default' => array(
        							'type' => 'Segment',
        							'options' => array(
        									'route' => '[/:action[/:id]]',
        									'constraints' => array(
        											'action' => '[a-zA-Z]*',
        											'id'	 => '[0-9]*'
        									),
        									'defaults' => array(
        									),
        							),
        					),
        			),
        	),
        ),
    ),
    'table-gateway' => array(
    	'map' => array(
    				'users' => 'AuthApplication\Model\User',
    				)
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'AuthApplication' => __DIR__ . '/../view',
        ),
    ),
    'acl' => array(
    		/**
    		 * Access Control List
    		 * -------------------
    		*/
  
    		'resources' => array(
    				'allow' => array(
    						'AuthApplication\Controller\Login' => array(
    								'login'	=> 'guest',
    								'logout'	=>'member',
    						),
    						'AuthApplication\Controller\Index' => array(
    								'index'	=> 'member',
    						),
    						'AuthApplication\Controller\Register' => array(
    								'register'	=> 'guest',
    								'edit'	=> 'member',
    								'changepassword'=>'member',
    								'loadImage'=>'member'
    						),
    				),
    				'deny' => array(
    						 
    				)
    		)
    ),
    'navigation' => array(
    		'default' => array(
    				array(
    						'label' => 'Login',
    						'route' => 'auth-login/process',
    						'controller' => 'Login',
    						'action'     => 'login',
    						'resource'	  => 'AuthApplication\Controller\Login',
    						'privilege'  => 'login',
    				),
    				array(
    						'label' => 'Logout',
    						'route' => 'auth-login/process',
    						'controller' => 'Login',
    						'action'     => 'logout',
    						'resource'	  => 'AuthApplication\Controller\Login',
    						'privilege'  => 'logout',
    				),
    				array(
    						'label' => 'User Profile',
    						'route' => 'auth-application',
    						'controller' => 'Index',
    						'action'     => 'index',
    						'resource'	  => 'AuthApplication\Controller\Index',
    						'privilege'  => 'index',
    				),	
    		)
    )
);
