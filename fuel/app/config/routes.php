<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	'actu'  => 'admin/13posts/index', // Route for actu page
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);