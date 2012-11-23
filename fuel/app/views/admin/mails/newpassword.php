<html>
<head>
</head>

<body>
    <?php echo Asset::css('newsletter.css'); ?>
    <div id="mail_body">
    
    	<div class="main_container">
    	    
    	    <div id="head_banner">
    	        <?php echo Asset::img('season13/mail/simple_head.jpg'); ?>
    	        <h1>Ton nouveau mot de passe</h1>
    	    </div>
    	    
    	    <div id="content_container">
    	        <div class="text_container">
    	        
    	        <h5>
    	            Bonjour,<br/>
    	            <br/>
    	            Voici ton nouveau mot de passe : <?php echo $new_pass; ?><br/>
    	            <br/>
    	            Tu peux maintenant te connecter avec ce nouveau mot de passe.<br/>
    	            <br/>
    	            Tu veux le changer ?<br/>
    	            Clique sur ton nom en haut à droite lorsque tu es connecté.
    	        </h5>
    	        
    	        </div>
    	    </div>
    	    
    	    <h5 class="outer_msg">
    	        <a href="http://season13.com">Season13</a><br/>
    	        03 20 24 79 56<br/>
    	        <a href="mailto:contact@encrenomade.com">contact@encrenomade.com</a><br/>
    	        99A bld Descat 59200 Tourcoing<br/>
    	    </h5>
    	</div>
    	
</div>
</body>