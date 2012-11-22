<html>
<head>
    <?php echo Asset::css('newsletter.css'); ?>
</head>

<body>
    <div id="mail_body">
    
    	<div class="main_container">
    	    <?php if(isset($link)): ?>
        	    <h5 class="outer_msg">
        	        Si ce message ne s’affiche pas <a href="<?php echo $link; ?>">cliquez-ici</a>
        	    </h5>
    	    <?php endif; ?>
    	    
    	    <div id="head_banner">
    	        <?php echo Asset::img('season13/mail/simple_head.jpg'); ?>
    	        <h1>Newsletter</h1>
    	    </div>
    	    
    	    <div id="content_container">
    	        <?php if(isset($img)) echo Asset::img($img); ?>
    	    
    	        <div class="text_container">
    	        <?php if(isset($subject)): ?>
    	            <h2><?php echo $subject; ?></h2>
    	        <?php endif; ?>
    	        <?php if(isset($content)): ?>
    	            <h5><?php echo $content; ?></h5>
    	        <?php endif; ?>
    	        </div>
    	    </div>
    	    
    	    <h5 class="outer_msg">
    	        Season13 – 99A bld Descat 59200 Tourcoing
    	    </h5>
    	</div>
    	
</div>
</body>