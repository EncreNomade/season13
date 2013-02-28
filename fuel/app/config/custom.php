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
	
	'payzen' => array(
	    //Identifiant Boutique à récupérer dans le Back office Payzen
	    'vads_site_id' => "",
	    
	    // Certificat à récupérer dans le Back office Payzen. Attention ce certificat est différent en fonction du mode TEST ou PRODUCTION. Le certificat n'est pas envoyé à la plateforme de paiement mais intervient dans le calcul de la signature.
	    'key' => "",
	    
	    // Mode de fonctionnement. Valeur = TEST ou PRODUCTION
	    'vads_ctx_mode' => "TEST",
	    
	    // Ce paramètre est obligatoire et doit être valorisé à V2.
	    'vads_version' => "V2",
	    
	    // Langue dans laquelle s'affiche la page de paiement.( fr pour Français , en pour Anglais. )
	    'vads_language' => "fr",
	    
	    // Ce paramètre est obligatoire et doit être valorisé à PAYMENT.
	    'vads_page_action' => 'PAYMENT',
	    
	    // Ce paramètre est valorisé à INTERACTIVE si la saisie de carte est réalisée sur la plateforme de paiement.
	    'vads_action_mode' => 'INTERACTIVE',
	    
	    // Ce paramètre est valorisé à SINGLE pour un paiement simple.
	    'vads_payment_config' => 'SINGLE',
	    
	    // Url de retour à la boutique. Lorsque le client clique sur "retourner à la boutique". Cette url permet de faire un traitement affichage en indiquant l'état du paiement. Il est fortement conseillé de ne pas faire de traitement en base de données (mise à jour commande, enregistrement commande) suite à l'analyse du résultat du paiement.
	    // C'est l'appel de l'url serveur qui doit vous permettre de mettre à jour la base de données.
	    'vads_url_return' => Fuel::$env == Fuel::DEVELOPMENT ? "http://season13.com/achat/order/payzenReturn" : "http://".$_SERVER['HTTP_HOST']."/achat/order/payzenReturn",
	    
	    // Ce paramètre définit dans quel mode seront renvoyés les paramètres lors du retour à la boutique (3 valeurs possibles GET / POST / NONE). Si ce champ n'est pas posté alors la plateforme ne renvoie aucun paramètre lors du retour à la boutique par l'internaute.
	    'vads_return_mode' => 'GET',
	    
	    // Ce paramètre définit la durée avant un retour automatique à la boutique pour un paiement accepté(valeur exprimée en seconde).
	    'vads_redirect_success_timeout' => 5,
	    
	    // Ce paramètre définit un message sur la page de paiement avant le retour automatique à la boutique dans le cas d'un paiement accepté.
	    'vads_redirect_success_message' => "Redirection vers la boutique dans quelques instants",
	    
	    // Ce paramètre définit la durée avant un retour automatique à la boutique pour un paiement échoué(valeur exprimée en seconde).
	    'vads_redirect_error_timeout' => 5,
	    
	    // Ce paramètre définit un message sur la page de paiement avant le retour automatique à la boutique dans le cas d'un paiement échoué.
	    'vads_redirect_error_message' => "Redirection vers la boutique dans quelques instants",
	),
);
