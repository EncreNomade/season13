<?php
/**
 * The custom settings.
 */

$SandboxFlag = false;

return array(
	'remote_path' => '/season13/public/',
	
	'possesion_src' => array(
        1 => 'free',
	    2 => 'invitation',
	    3 => 'buybutton',
	    4 => 'code_promo',
	    5 => 'offer_nopayment',
	    6 => 'fblike',
	    7 => 'external_order',
	    8 => 'season13_order',
	    9 => 'gift_with_order',
	),
	
	'fbapp' => array(
	    'id' => '141570392646490',
	    'secret' => '152a5d45dd79ce82924f1c9a792caf96',
	),
	
	'paypal' => array(
	    // PayPal settings
	    'account_email' => 'mseygnerole@encrenomade.com',
	    'return_url' => Fuel::$env == Fuel::DEVELOPMENT ? "http://season13.com/achat/order/paypalConfirm" : "http://".$_SERVER['HTTP_HOST']."/achat/order/paypalConfirm",
	    'cancel_url' => Fuel::$env == Fuel::DEVELOPMENT ? "http://season13.com/achat/order/cancel" : "http://".$_SERVER['HTTP_HOST']."/achat/order/cancel",
	    
	    //'------------------------------------
	    //' PayPal API Credentials
	    //'------------------------------------
	    'id_api' => "mseygnerole_api1.encrenomade.com",
	    'pass_api' => "N4NRNF2S5AM9Q79L",
	    'signature' => "AESpvwg.b5ZaOBvpaXy5.19ELPKUAmf31sC0yrS3p0tkXhZ-U3gO8R9c",
	    
	    'API_UserName' => $SandboxFlag ? "hling_1358162204_biz_api1.encrenomade.com" : "mseygnerole_api1.encrenomade.com",
	    
	    'API_Password' => $SandboxFlag ? "1358162227" : "N4NRNF2S5AM9Q79L",
	    
	    'API_Signature' => $SandboxFlag ? "A0BExctOvTC4SbLvY4TjpGYIJLIMAYGNVdRR4J29yUe6bh2wjtZyq9pY" : "AESpvwg.b5ZaOBvpaXy5.19ELPKUAmf31sC0yrS3p0tkXhZ-U3gO8R9c",
	    
	    'PROXY_HOST' => '127.0.0.1',
	    'PROXY_PORT' => '808',
	    
	    'SandboxFlag' => $SandboxFlag,
	    // BN Code 	is only applicable for partners
	    'sBNCode' => "PP-ECWizard",
	    
    	/*	
    	' Define the PayPal Redirect URLs.  
    	' 	This is the URL that the buyer is first sent to do authorize payment with their paypal account
    	' 	change the URL depending if you are testing on the sandbox or the live PayPal site
    	'
    	' For the sandbox, the URL is       https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
    	' For the live site, the URL is        https://www.paypal.com/webscr&cmd=_express-checkout&token=
    	*/
    	
    	'API_Endpoint' => $SandboxFlag ? "https://api-3t.sandbox.paypal.com/nvp" : "https://api-3t.paypal.com/nvp",
    	
    	'PAYPAL_URL' => $SandboxFlag ? "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=" : "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=",
    	
    	'PAYPAL_DG_URL' => $SandboxFlag ? "https://www.sandbox.paypal.com/incontext?token=" : "https://www.paypal.com/incontext?token=",
    
    	'USE_PROXY' => false,
    	'version' => "84",
	),
	
	'presta' => array(
	    '_COOKIE_KEY_' => 'Oft84wshyVkbtEgVEc1ndiOqGhtAHcqFWHiKPF54MWBuLwQWfoD7vVJV',
	),
);
