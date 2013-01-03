<?php

return array(
    'auth' => array(
        1 => 'Mot de passe ou identifiant erroné',
        2 => 'Identifiant manquant',
        3 => 'Mot de passe manquant',
        10 => 'Problème de connexion à Facebook',
        11 => 'Problème de connexion à Facebook, tu peux réessayer la prochaine fois',
        12 => 'Facebook id n\'est lié à aucun compte',
        13 => 'Ton facebook information n\'a pas pu être sauvegardé, tu peux réessayer la prochaine fois',
    ),

    // Error codes while request the access to a story
	'story_access' => array(
	    101 => "L'épisode est indisponible pour le moment.",
	    102 => "Aucun épisode n'était demandé",
	    103 => "L'épisode n'existe pas ou il est indisponible.",
	    201 => "Tu dois te connecter ou t'inscrire sur SEASON13.com.",
	    202 => "Tu n'as pas l'accès à cet épisode.",
	    303 => "Nous t'offrons cet épisode si tu envoies cette invitation à 5 amis",
	    304 => "Nous t'offrons cet épisode si tu aimes Season13.com sur Facebook",
	    'default' => "L'épisode n'existe pas ou il est indisponible.",
	),
	
	// Error codes while upload a file
	'upload' => array(
	    1101 => "Fichier n'existe pas",
	    1102 => "La configuration de téléchargement n'est pas valide",
	    1199 => "Erreur inconnu",
	    1201 => "Echec à enregisterer le téléchargement",
	),
	
	// Error codes while request to reset a pasword
	'change_pass' => array(
	    2101 => "Adresse email erronée !",
	    2102 => "Nous n'avons pas d'utilisateur avec cette adresse !",
	),
	
	// Error codes for webservice
	'webservice' => array(
	    3001 => "Application not exist",
	    3002 => "Access token not found or not valid",
	    3003 => "Access microtime not provided",
	    3004 => "Application not permitted for the api requested",
	    
	    // Order
	    3101 => "User can not be added to the database of user",
	    3102 => "Reference of product not exist",
	    3103 => "Order registration failed",
	    3104 => "Request validation failed: one or more information is missing",
	    3105 => "Product is not valid, content extracting error, contact the provider",
	    3106 => "Failed to register one or more user possesion record",
	    3107 => "Order id not given",
	    3108 => "Order id not found",
	    3109 => "Request has been denied", // App id not matched
	    3110 => "Owner user of this order not exist",
	    
	    // Prodcut
	    3201 => "Product id not given",
	    3202 => "Product id not found",
	    3203 => "User email not given",
	    3204 => "User not found",
	    3205 => "Order for the combination of the product and the user requested can not be found",
	    3206 => "Order canceled",
	    
	    // Episode
	    3301 => "User email not given",
	    3302 => "Episode id not given",
	    3303 => "User not found",
	    3304 => "Episode not found",
	    
	    3999 => "Unknown error",
	),
);