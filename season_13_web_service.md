#Web Service Season 13

Season 13 commercialise des feuilletons organisés de la manière suivante :<br/>
Une histoire peut être racontée sur plusieurs saisons.<br/>
Chaque saison comprend plusieurs épisodes.<br/>

Exemple : <br/>
Voodoo Connection Saison 1 : Épisode 1 à 6<br/>
Voodoo Connection Saison 2 : Épisode 7 à 12

##1. Description des Applications

Les applications de Season 13 Web Service sont administrées par Encre Nomade. Encre Nomade distribue l'identifiant d'application `appid` (32 lettres en caractères et chiffres) et le mot de passe `appsecret` (16 lettres en caractères et chiffres) à chaque application.

Exemple :

	appname 	: SampleApp
	description	: A sample application
	appid 		: af869b310c1a2a2d76260a35224b832b
	appsecret 	: 3YLlXNTsUno2obBy

##2. Données obligatoires d'envoi

Chaque fois qu'une application utilise les APIs web service, certaines informations sont obligatoires pour vérifier le droit d'accès. Voici les données obligatoires :

- `appid` : L'identifiant de votre application

- `microtime` : Timestamp du moment d'envoi

- `token` : Le jeton d'accès est composé de la façon suivante
		
		md5( appid + appsecret + microtime )
		
Exemple :
	
	$data = array (
		'appid' => 'af869b310c1a2a2d76260a35224b832b',
		'microtime' => '1234567890',
		'token' => '11a6f80053e9a504125ee5dbf0e81cab',
	)
	
##3. Données retournées

Les données retournées sont sous la forme d'un tableau associatif au format JSON. La clé `success` indique le succès de la requête.

##4. APIs Web Service

###4.1. order

Le webservice `order` sert à créer ou obtenir les enregistrements d'achats sur Season 13.

####POST

Une fois que les utlisateurs finalisent leur achats sur votre site, les achats peuvent être enregistrés en utilisant le webservice : `order` avec la methode `POST`.

1. Méthode de requête : `POST`

- Adresse url : ___http://www.season13.com/ws/order___

- Données d'envoi :

	- Les données obligatoires d'application.
	- `owner` : Le mail de l'utilisateur qui a réalisé cet achat.
	- `username` : Le pseudo de l'utilisateur.
	- `reference` : L'ISBN du produit acheté.
	- `order_source` : La description d'achat, par exemple 'Achat sur site mobile: mobi.****.com'.
	- `price` : Le prix.
	
			ex : $data = array (
				'appid' => 'af869b310c1a2a2d76260a35224b832b',
				'microtime' => '1234567890',
				'token' => '5dc48577c5238b9038231f3568a7adb0',
				'owner' => 'test@test.com',
            	'username' => 'wstester',
            	'reference' => 'ISBN9782717765332',
            	'order_source' => 'Season 13 Site Order',
            	'price' => '0.99'
			)
	
- Données retournées pour une requête réussie :

		ex : { 
			'success' 	: true, 
			'order_id' 	: 9
		}

####GET

Après avoir créé un enregistrement d'achat, l'application peut obtenir les informations avec la méthode `GET`.

1. Méthode de requête : `GET`

- Adresse url : ___http://www.season13.com/ws/order___

- Données d'envoi :
	
	- Les données obligatoires d'application.
	- `order_id` : L'indentifiant d'enregistrement d'achat.
	
			ex : $data = array(
            	'appid' => 'a3db720844c6c391f2297b4fbece7d02',
            	'microtime' => '1234567890',
            	'token' => '520a657e08f0f73c8ae6eb53427a2956',
            	'order_id' => '9'
        	)

- Données retournées pour une requête réussie :

		ex : { 
			'success' : true, 
			'order' : {
				'id' 			: 9,
				'reference' 	: 'ISBN9782717765332',
				'owner' 		: 'test@test.com',
				'order_source' 	: 'Season 13 Site Order',
				'appid' 		: 'a3db720844c6c391f2297b4fbece7d02',
				'price' 		: '0.99',
				'state' 		: 'FINALIZE',
				'datetime' 		: '1357516220'
			}
		}

###4.2. cancel_order

Ce web service sert à annuler un enregistrement d'achat.

####POST

1. Méthode de requête : `POST`

- Adresse url : ___http://www.season13.com/ws/cancel_order___

- Données d'envoi :
	
	- Les données obligatoires d'application.
	- `order_id` : L'indentifiant de l'enregistrement d'achat.

- Données retournées pour une requête réussie :

		ex : { 
			'success' 	: true, 
			'order_id' 	: 9
		}

###4.3. product

Ce web service sert à récupérer des informations pour un produit.

####GET

1. Méthode de requête : `GET`

- Adresse url : ___http://www.season13.com/ws/product___

- Données d'envoi :
	
	- Les données obligatoires d'application.
	- `reference` : La référence du produit.

- Données retournées pour une requête réussie :

		ex : { 
			'success' : true, 
			'product' : {
				'reference' 		: 'ISBN9782717765332',
                'type' 				: 'episode',
                'pack' 				: false,
                'content' 			: '[5]',
                'resume' 			: 'Voodoo Connection Season 1 Episode 5 : Les Enfants de l'Appocalypse',
                'title' 			: 'Les Enfants de l'Appocalypse',
                'author_fullname' 	: Chris Debien,
                'author_bio' 		: 'Né par un beau jour d’automne, j’ai la chance de mener trois vies parallèles : …',
                'images' 			: '["http://season13.com/voodoo/season1/ep5/ep5_expo.jpg"]',
                'extrait' 			: 'http://season13.com/ws/extrait/Voodoo_Connection/season1/episode5',
                'keywords' 			: 'Voodoo Connection, Zombie',
                'category' 			: 'Feuilleton interactif',
                'price' 			: '0.99',
			}
		}

###4.4. access_product

Ce web service vous fournit un jeton d'accès pour que l'utilisateur de votre application puisse accéder à la page du produit. Ce jeton est uniquement associé avec l'utilisateur demandé. Si l'utilisateur ne possède pas le produit, vous recevrez une erreur.

####GET

1. Méthode de requête : `GET`

- Adresse url : ___http://www.season13.com/ws/access_product___

- Données d'envoi :
	
	- Les datas obligatoires d'application.
	- `reference` : La référence du produit.
	- `user` : Le mail d'utilisateur qui possèdera l'accès.

- Données retournées pour une requête réussie :

		ex : { 
			'success' 		: true, 
			'access_token' 	: 'GjYl3PEFqiTml-oLaxPatT_wD_vdi7voa6rq8dxDm6bmQTw6Q--Dp77pi2kKJRlFVHhph943OYaal44E7cSak_hD4j43B9e5i2fnMBHMfnMjC5h76cPCzBx3yQ3-5HunZkUxUlV2WTJfblNjWmQ5NV9tMjBGdlJFemVqbzRpc3pDSW1kbFRqdUFUNA',
			'link'			: 'http://www.season13.com/ws/product/ISBN9782717765332?user=test@test.com&access_token=GjYl3PEFqiTml-oLaxPatT_wD_vdi7voa6rq8dxDm6bmQTw6Q--Dp77pi2kKJRlFVHhph943OYaal44E7cSak_hD4j43B9e5i2fnMBHMfnMjC5h76cPCzBx3yQ3-5HunZkUxUlV2WTJfblNjWmQ5NV9tMjBGdlJFemVqbzRpc3pDSW1kbFRqdUFUNA'
		}

###4.5. access_product_sav

Ce web service vous fournit un jeton d'accès (access token) pour que le service après vente de votre application puisse accéder à la page d'un produit pour le tester. Ce jeton sera valable pendant 24 heures.

####GET

1. Méthode de requête : `GET`

- Adresse url : ___http://www.season13.com/ws/access_product_sav___

- Données d'envoi :
	
	- Les données obligatoires d'application.
	- `reference` : La référence du produit.

- Données retournées pour une requête réussie :

		ex : { 
			'success' 		: true, 
			'access_token' 	: 'lu6p2dYvbZaBfAxHkpxmlJOrmsljtvFlQh4ryFP3se4czb_UzVpQjHwM9qafto4vgX0yGG8oDVUvueegXteh79bZ8E5ktlPg5uIbEdeWAINQNnNaMERTWnl2dzdxbEZWYUtNTFNIM0JZdWstM3lpX192N1NLcnRiYS1r',
			'link'			: 'http://www.season13.com/ws/product/ISBN9782717765332?user=SAV&access_token=lu6p2dYvbZaBfAxHkpxmlJOrmsljtvFlQh4ryFP3se4czb_UzVpQjHwM9qafto4vgX0yGG8oDVUvueegXteh79bZ8E5ktlPg5uIbEdeWAINQNnNaMERTWnl2dzdxbEZWYUtNTFNIM0JZdWstM3lpX192N1NLcnRiYS1r'
		}

<!--
###4.6. episode_for_user

Ce web service vous fournit un jeton d'accès pour que l'utilisateur de votre application puisse accéder à la page d'un épisode. Ce jeton est uniquement associé avec l'utilisateur demandé. Si l'utilisateur ne possède pas l'épisode, vous recevrez une erreur.

####GET

1. Méthode de requête : `GET`

- Adresse url : ___http://www.season13.com/ws/episode_for_user___

- Données d'envoi :
	
	- Les données obligatoires d'application.
	- `epid` : L'id de l'épisode.
	- `user` : Le mail d'utilisateur qui possèdera l'accès.

- Données retournées pour une requête réussie :

		ex : { 
			'success' 		: true, 
			'access_token' 	: 'SZ_645l4_dBNyna6W8Yn_vVIqkmoMOULWF3Bjci3anmC_V9AQsTomQuu3EzwVl0nVAx88yFZ38RUrFz7EW91SpZ0mag0FOoz3AJPhZs8NTQItU-g1KCgG5rtw4JKxbeeZXctSXctNlZJUHBrdlZpUTI4bVpUQTBjeDlPZUlrZk5rdTJGNVRhVjNvWQ',
			'link'			: 'http://www.season13.com/ws/Voodoo_Connection/season1/episode5?user=test@test.com&access_token=SZ_645l4_dBNyna6W8Yn_vVIqkmoMOULWF3Bjci3anmC_V9AQsTomQuu3EzwVl0nVAx88yFZ38RUrFz7EW91SpZ0mag0FOoz3AJPhZs8NTQItU-g1KCgG5rtw4JKxbeeZXctSXctNlZJUHBrdlZpUTI4bVpUQTBjeDlPZUlrZk5rdTJGNVRhVjNvWQ'
		}
-->

##Erreurs et Exceptions

| Code d'erreur (errorCode) | Message d'erreur (errorMessage) |
| ------------- | ---------------- |
| 3001 | Application not exist |
| 3002 | Access token not found or not valid |
| 3003 | Access microtime not provided |
| 3004 | Application not permitted for the api requested |
| 3101 | User can not be added to the database of user |
| 3102 | Reference of product not exist |
| 3103 | Order registration failed |
| 3104 | Request validation failed: one or more information is missing |
| 3105 | Product is not valid, content extracting error, contact the provider |
| 3106 | Failed to register one or more user possesion record |
| 3107 | Order id not given |
| 3108 | Order id not found |
| 3109 | Request has been denied |
| 3110 | Owner user of this order not exist |
| 3201 | Product id not given |
| 3202 | Product id not found |
| 3203 | User email not given |
| 3204 | User not found |
| 3205 | Order for the combination of the product and the user requested can not be found |
| 3206 | Order canceled |
| 3301 | User email not given |
| 3302 | Episode id not given |
| 3303 | User not found |
| 3304 | Episode not found |
| 3999 | Unknown error |

##5. Pages de Web Service

###5.1. Page de produit

Si le produit est un pack, cette page affichera la liste des épisodes de ce pack. L'utilisateur peut cliquer sur les épisodes pour les visualiser.

Si le produit est un seul épisode, cette page sera directement redirigée vers la page de l'épisode.

1. Adresse url : __http://www.season13.com/ws/product/_(:reference)___

- Données d'envoi :
	
	- `user` : Le mail d'utilisateur qui possède l'accès.
	- `access_token` : Le jeton d'accès obtenu avec le web service `access_product` ou `access_product_sav`.
	
			ex : http://www.season13.com/ws/product/ISBN9782717765332?user=test@test.com&access_token=GjYl3PEFqiTml-oLaxPatT_wD_vdi7voa6rq8dxDm6bmQTw6Q--Dp77pi2kKJRlFVHhph943OYaal44E7cSak_hD4j43B9e5i2fnMBHMfnMjC5h76cPCzBx3yQ3-5HunZkUxUlV2WTJfblNjWmQ5NV9tMjBGdlJFemVqbzRpc3pDSW1kbFRqdUFUNA

- Dans certain cas, cette page sera redirigée vers la page 404 ou la page forbidden : 

	- Si la référence n'est pas fournie.
	- Si l'utilisateur n'est pas fourni ou s'il n'existe pas.
	- Si le jeton d'accès n'est pas fourni ou s'il n'est pas valide.
	- Si le produit n'existe pas.
	
<!--
###5.2. Page d'épisode

Cette page affichera

1. Adresse url : __http://www.season13.com/ws/_(:story)_/season_(:sid)_/episode_(:eid)___

- Données d'envoi :
	
	- `user` : Le mail d'utilisateur qui possède l'accès.
	- `access_token` : Le jeton d'accès obtenu avec le web service `access_product` ou `episode_for_user`.
	
			ex : http://www.season13.com/ws/Voodoo_Connection/season1/episode5?user=test@test.com&access_token=SZ_645l4_dBNyna6W8Yn_vVIqkmoMOULWF3Bjci3anmC_V9AQsTomQuu3EzwVl0nVAx88yFZ38RUrFz7EW91SpZ0mag0FOoz3AJPhZs8NTQItU-g1KCgG5rtw4JKxbeeZXctSXctNlZJUHBrdlZpUTI4bVpUQTBjeDlPZUlrZk5rdTJGNVRhVjNvWQ

- Dans certain cas, cette page sera redirigée vers la page 404 ou la page forbidden : 

	- Si le nom d'histoire, l'id de saison ou l'id d'épisode n'est pas fournit dans l'adresse.
	- Si l'utilisateur n'est pas fourni ou s'il n'existe pas.
	- Si le jeton d'accès n'est pas fourni ou s'il n'est pas valide.
	- Si l'épisode n'existe pas.
-->