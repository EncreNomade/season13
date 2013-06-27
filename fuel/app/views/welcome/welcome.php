<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="Description" content="Bienvenue - Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection" />
	
	<title>Bienvenue - SEASON 13</title>
	
	<?php echo Asset::css('pagewelcome.css'); ?>
	
    <?php if( !Auth::check() || Auth::member(3) || Auth::member(5) ): ?>
    	<script type="text/javascript">
    	
    	  var _gaq = _gaq || [];
    	  _gaq.push(['_setAccount', 'UA-35640835-1']);
    	  _gaq.push(['_setDomainName', 'season13.com']);
    	  _gaq.push(['_setAllowLinker', true]);
    	  _gaq.push(['_trackPageview']);
    	  
    	  var _gaq = _gaq || [];
    	  _gaq.push(['_setAccount', 'UA-36203496-1']);
    	  _gaq.push(['_setDomainName', 'season13.com']);
    	  _gaq.push(['_setAllowLinker', true]);
    	  _gaq.push(['_trackPageview']);
    	
    	  (function() {
    	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    	  })();
    	
    	</script>
    <?php endif; ?>
	
</head>
<body>
    
    <div id="background">
        <?php echo Asset::img('season13/welcome/background.jpg'); ?>
    </div>

    <header>
        <div class="header_left">
            <a href="<?php echo $base_url; ?>" id="logoLink" title="LOGO SEASON 13">
                <?php echo Asset::img('season13/logo_white.png'); ?>
            </a>
        </div>
        
        <div class="center">
            <a href="<?php echo $base_url; ?>Voodoo_Connection/season1/episode1?utm_source=welcomebtn&utm_medium=cpc" id="discoverbtn">
                <?php echo Asset::img('season13/welcome/discoverbtn.png'); ?>
            </a>
        </div>
        
        <div class="header_right">
            <a href="<?php echo $base_url; ?>" id="sitelink">
                <?php echo Asset::img('season13/welcome/sitelink.png'); ?>
            </a>
        </div>
    </header>
    
    <section>
        <article id="title">
            <?php echo Asset::img('season13/illus/titre_2.png', array('alt' => 'Voodoo Connection SEASON 13')); ?>
        </article>
        
        <article id="video">
            <iframe width="560" height="315" src="http://www.youtube-nocookie.com/embed/lwuMe5fzeyU?rel=0&vq=hd720" frameborder="0" allowfullscreen></iframe>
        </article>
    </section>
    
</body>
</html>
