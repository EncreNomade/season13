<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta charset="utf-8">
	<meta name="Description" content="<?php if( isset($description) ) echo $description; else echo "Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";  ?>" />
	
	<meta property="og:title" content="SEASON13" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://season13.com/<?php echo Uri::string(); ?>" />
	<meta property="og:image" content="http://season13.com/voodoo/cover.jpg" />
	<meta property="og:site_name" content="SEASON13.com" />
	<meta property="og:description" content="<?php if( isset($description) ) echo $description; else echo "Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web.";  ?>" />
	<meta property="fb:app_id" content="141570392646490" />
	
	<meta name="robots" content="noindex"/>
	<meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, width=device-width, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
	
	<title><?php if(isset($title)) echo $title; ?></title>
	<?php
	    echo Asset::css('BebasNeue.css');
	    echo Asset::css('DroidSans.css');
	    echo Asset::css('template.mobi.css');
        echo Asset::css('dialog_auth_msg.mobi.css');
	    echo Asset::css('cart.mobi.css');
	    if(isset($css_supp)) echo Asset::css($css_supp);
	    
	    // Configuration
	    echo Asset::js('config.js');
	    
	    // Public libs
	    echo Asset::js('lib/jquery-1.9.1.min.js');
	    echo Asset::js('lib/jquery.scrollTo-1.4.2-min.js');
	    echo Asset::js('lib/jquery.parallax-1.1.3.js');
	    echo Asset::js('lib/jquery.form.min.js');
	    
	    // Private js
	    if(Fuel::$env == Fuel::DEVELOPMENT || Fuel::$env == Fuel::TEST) {
    	    echo Asset::js('lib/fbapi.js');
    	    echo Asset::js('template.mobi.js');
            echo Asset::js('cart.js');
            echo Asset::js('auth.js');
        }
        else {
            echo Asset::js('template_main.min.js');
        }
	    if(isset($js_supp)) echo Asset::js($js_supp);
	?>
	
	<script type="text/javascript">
	
	  addEventListener("load", function(){
	      setTimeout(function(){window.scrollTo(0, 1);}, 0);
	      $('body').css({'margin':'0px','padding':'0px'});
	  }, false);
	
<?php if( !Auth::check() || Auth::member(3) || Auth::member(5) ): ?>

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

<?php endif; ?>
	
	</script>
	
</head>
<body><div class="card">
    <div id="fb-root"></div>
    <script>
    // Load the SDK Asynchronously
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId="+config.fbAppId;
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Init the SDK upon load
    window.fbAsyncInit = function() {
        FB.init({
            appId      : config.fbAppId, // App ID
            channelUrl : 'http://season13.com/channelfile', // Path to your Channel File
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
        });
    }
    
    config.base_url = "http://"+window.location.hostname + (config.readerMode=="debug"?":8888":"") + config.publicRoot;
    </script>
    <?php 
        // output the javascript function
        echo Security::js_set_token(); 
    ?>

    <header>
        <div id="logo">
            <?php echo Asset::img('season13/logo_white.png'); ?>
        </div>
        
        <h1>Voodoo Connection</h1>
        <!--
        <menu>
            <ul>
            <?php if($current_user == null): ?>
                <li class="text_sep_vertical"></li>
                <li id="open_auth_express">Vous</li>
            <?php else: ?>
                <li id="user_id"><?php echo $current_user->pseudo ?>
                    <ul>
                        <li id="user_id">Votre compte</li>
                        <li id="logout">Logout</li>
                    </ul>
                </li>
            <?php endif; ?>
            </ul>
        </menu>-->
        
        <?php if($current_user == null): ?>
            <div id="auth_express_dialog" class="dialog">
                <div class="close"></div>
                <div class="sep_line"></div>
                <?php echo View::forge('story/access/auth')->render(); ?>            
        <?php else: ?>
            <div id="update_dialog" class="dialog">
                <div class="close"></div>
                <div class="sep_line"></div>
                <?php echo View::forge('auth/update_form')->render(); ?>
            </div>
        <?php endif; ?>
    </header>
    
    <article class="main_container">
        <?php if(isset($content)) echo $content; ?>
    </article>

	<footer>
	    <menu>
    	    <ul>
    	        <li<?php if($current_page == "concept") echo ' class="active"'; ?>><a href="<?php echo $base_url; ?>mobile/concept">Concept</a></li>
    	        <li<?php if($current_page == "histoire") echo ' class="active"'; ?>><a href="<?php echo $base_url; ?>mobile">Histoire</a></li>
    	        <li<?php if($current_page == "jeux") echo ' class="active"'; ?>><a href="<?php echo $base_url; ?>mobile/games">Jeux</a></li>
    	        <li<?php if($current_page == "config") echo ' class="active"'; ?>><a href="<?php echo $base_url; ?>mobile/config">Parent</a></li>
    	    </ul>
	    </menu>
	</footer>
	
	<script type="text/javascript">
    	$('div.card').children('header, footer').bind('touchmove', function(e) {
    	    e.preventDefault();
    	});
    	
    	var top = $('article.main_container').offset().top;
    	
	    $('article.main_container').bind('touchmove', function(e) {
	        if($(this).offset().top > top+2)
	            e.stopPropagation();
	    });
	</script>
</div></body>
</html>