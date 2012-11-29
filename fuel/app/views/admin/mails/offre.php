<html>
<head>
    <?php echo Asset::css('newsletter.css'); ?>
</head>

<body>
    
    <style>
        #mail_body {
            width: 100%;
            height: 100%;
            background: #ccc;
        }
        
        div.main_container {
            position: relative;
            margin: 20px auto;
            width: 600px;
            height: auto;
        }
        
        div.main_container #head_banner {
            position: relative;
            float: left;
            width: 600px;
            height: 100px;
            border-bottom: 6px solid rgb(246, 168, 0);
        }
        div.main_container #head_banner img {
            position: absolute;
            left: 0px;
            top: 0px;
            width: 600px;
            height: 100px;
        }
        div.main_container h1 {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 600px;
            height: 100px;
            text-align: center;
            font: bold 40px/100px Arial;
            color: #fff;
            padding: 0;
            margin: 0;
        }
        
        #content_container {
            position: relative;
            float: left;
            left: 0px;
            width: 500px;
            padding: 20px 50px;
            background: #fff;
        }
        
        #content_container img {
            position: relative;
            float: left;
            left: 0px;
            top: 0px;
            width: 180px;
            height: auto;
            margin: 0 20px 0 0;
        }
        
        #content_container div.text_container {
            position: relative;
            float: left;
            left: 0px;
            top: 0px;
            width: 300px;
            height: auto;
        }
        div.text_container h2 {
            text-align: left;
            color: rgb(246, 168, 0);
            font: bold 25px/36px Arial, Helvetica, Geneva, sans-serif;
        }
        div.text_container h5, div.text_container h4 {
            text-align: left;
            color: #000;
            font: normal 18px/28px Arial, Helvetica, Geneva, sans-serif;
            margin: 5px 0 10px 0;
        }
        div.text_container h5.from {
            text-align: right;
        }
        
        div.main_container h5.outer_msg {
            position: relative;
            float: left;
            width: 600px;
            text-align: center;
            font: normal 12px/20px Arial, Helvetica, Geneva, sans-serif;
            margin: 0;
            padding: 0;
        }
    </style>
    
    <div id="mail_body">
    
    	<div class="main_container">
    	    
    	    <div id="head_banner">
    	        <?php echo Asset::img('season13/mail/simple_head.jpg'); ?>
    	    </div>
    	    
    	    <div id="content_container">
    	        <h1 style="font: bold 40px/60px Arial;color: rgb(246, 168, 0);"><?php echo $subject; ?></h1>
    	        
    	        <div class="text_container">
    	        
    	        <h4 style="font: normal 18px/25px Arial, Helvetica, Geneva, sans-serif; margin: 5px 0 10px 0; color: #000;">
    	            <?php //echo html_entity_decode($content); ?>
    	            Merci de nous avoir aidés !<br/>
    	            <br/>
    	            Tu vas pouvoir découvrir gratuitement les 6 épisodes de la Saison I de Voodoo Connection.<br/>
    	            Et, dès que la saison II sera disponible, nous t’offrirons aussi les 6 chapitres !<br/>
    	            <br/>
    	            Découvre vite l’aventure de Simon !<br/>
    	            <br/>
    	            Ton code de cadeau: <?php echo $code; ?><br/>
    	            Clique <a href="<?php echo $codelink; ?>">ici</a> pour obtenir ton cadeau
    	        </h4>
    	        
    	        </div>
    	    </div>
    	    
    	    <h5 class="outer_msg" style="font: normal 12px/20px Arial, Helvetica, Geneva, sans-serif;">
    	        L’équipe de <a href="http://season13.com">Season13</a><!-- vous assure que votre mail n'est pas enregistré--><br/>
    	        <a href="http://www.facebook.com/season13officiel">Page facebook</a><br/>
    	        Téléphone: 03 20 24 79 56<br/>
    	        Mail: <a href="mailto:contact@encrenomade.com">contact@encrenomade.com</a><br/>
    	        Adresse: 99A bld Descat 59200 Tourcoing<br/>
    	    </h5>
    	</div>
    	
    </div>
</body>