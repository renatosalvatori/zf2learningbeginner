<?php
return array(
	// The Debug module expects the database service to be called "database".
	// If that is not the case add a service alias that points to the correct name.
	'service_manager' => array(
		'alias' => array(
			'database-profiler' => 'Zend\Db\Adapter\Profiler\Profiler' // This line is an example how to alias it
							// if the correct name of the service is Zend\Db\Adapter\Profiler\Profiler
		),
	),
	'view_manager' => array(
        'template_map' => array(
        	// This is the debug template that surrounds the page.
            // You can change the value of the kye to point to a view template
            // file that is more shiny.
        	'debug/layout/sidebar' => __DIR__ . '/../../vendor/Debug/view/debug/layout/sidebar.phtml',
        )
    ),
);
