<?php
	$settings = [
	'host'          =>      'localhost',
	'username'      =>      'digicono_HRadmin',
	'password'      =>      'DigiC0n0nlin3!',
	'dbname'        =>      'internal'
	];

	$link = new mysqli($settings['host'],$settings['username'],$settings['password'],$settings['dbname']);
	if($link->connect_errno){
		printf("Connect failed: %s\n", $link->connect_error);
	}		
	
	
?>