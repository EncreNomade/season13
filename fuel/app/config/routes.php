<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	'actu'    => 'admin/13posts/index', // Route for actu page
	'concept' => 'welcome/concept', // Route for concept page
	'story'   => 'story/index', // Route for episode page
	'upgradenav' => 'welcome/upgradenav', // Route for upgrade navigator notification page
	'mentionslegals' => 'welcome/mentionslegals',
	'contact' => 'welcome/contact',
	'thanksto' => 'welcome/thanksto',
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);