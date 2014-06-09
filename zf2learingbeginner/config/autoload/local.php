<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
    'db' => array(
    		'driver' => 'Pdo_Mysql', //The database driver. Mysqli, Sqlsrv, Pdo_Sqlite, Pdo_Mysql, Pdo=OtherPdoDriver
    		'database' => 'zf2learningbeginner', // 	generally required 	the name of the database (schema)
    		'username' => 'root', // generally required 	the connection username
    		'password' => 'poi890', // 	generally required 	the connection password
    		'hostname' => 'localhost', // not generally required 	the IP address or hostname to connect to
    		// 'port' => 1234,  	// not generally required 	the port to connect to (if applicable)
    		// 'charset' => 'utf8',  //	not generally required 	the character set to use
    		'options' => array (
    			'buffer_results' => 1
    		)
    )
);
