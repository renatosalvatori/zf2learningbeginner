<?php

return array(
    'acl' => array(
        /**
         * By default the ACL is stored in this config file.
         * If you activate the database_storage ACL will be constructed from the database via Doctrine
         * and the roles and resources defined in this config wil be ignored.
         * 
         * Defaults to false.
         */
        'use_database_storage' => false,
        /**
         * The route where users are redirected if access is denied.
         * Set to empty array to disable redirection.
         */
        'redirect_route' => array(
            'params' => array(
                'controller' => '',
                'action' => '',
                //'id' => '1',
            ),
            'options' => array(
				// We should redirect to an action Controller accessable for everyone. And this is "home" route
				// There should be a rule in the Acl allowing every role access to the action and controller
				// Usually this is the homepage action in our case CsnCms\Controller\Index action frontPageAction
				// the route 'home' = '/' should be overriden by CsnCms
				// In the case we are using login we enter an endless redirect. If you are loged in in the system as a member
				// to hide from the navigation the login action the coleagues are using Acl to deny access to login.
				// The CsnAuthorisation trys to redirect to not accessable action loginAction and it gets redirected back to it.
				// Much better is to redirect to an action for sure accessable from everyone and there is no better candidate than the homepage
				// the landing page for the requests to the domain.
                'name' => 'access-denie', // 'login', 
            ),
        ),
        /**
         * Access Control List
         * -------------------
         */
        'roles' => array(
            'guest'   => null,
            'member'  => 'guest',
            'admin'  => 'member',
        ),
        'resources' => array(
            'allow' => array(
            	/*'AuthApplication\Controller\Login' => array(
					'login'	=> 'guest',
					'logout'	=>'guest',
				),
				'AuthApplication\Controller\Index' => array(
					'index'	=> 'guest',
				),
            	'AuthApplication\Controller\Register' => array(
            				'register'	=> 'guest',
            				'edit'	=> 'member',
            				'changepassword'=>'member',
            				'loadImage'=>'member'
            	),*/
				'Application\Controller\Index' => array(
					'index'	=> 'guest',
					'notallowed'	=> 'guest', 
				),
            	
            ),
            'deny' => array(
                       
            )
        )
    )
);



?>