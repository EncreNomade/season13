<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	'ws404'   => 'welcome/ws404',
	'news'    => 'admin/13posts/index', // Route for actu page
	'concept' => 'welcome/concept', // Route for concept page
	'upgradenav' => 'welcome/upgradenav', // Route for upgrade navigator notification page
	'wsupgradenav' => 'welcome/wsupgradenav',
	'mentionslegales' => 'welcome/mentionslegales',
	'contact' => 'welcome/contact',
	'thanksto' => 'welcome/thanksto',
	'aboutus' => 'welcome/aboutus',
	'cadeau'   => 'welcome/cadeau',
	
	'(:segment)/season(:num)/episode(:num)' => 'story/index/$1/$2/$3',
	'ws/(:segment)/season(:num)/episode(:num)' => 'story/webservice/$1/$2/$3',
	'extrait/(:segment)/season(:num)/episode(:num)' => 'story/extrait/$1/$2/$3',
	'ws/extrait/(:segment)/season(:num)/episode(:num)' => 'story/wsextrait/$1/$2/$3',
	'ws/product/404' => 'achat/viewproduct/404',
	'ws/product/(:segment)' => 'achat/viewproduct/webservice/$1',
	'story' => 'story/index/Voodoo_Connection/1',
	'ws/(:segment)' => 'webservice/wsbase/$1',
);