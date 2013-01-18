<?php 
    $sections = array("accueil", "episode", "other");
    
    $section = $sections[0];
    if(isset($_GET['s'])) $section = $_GET['s'];
    if( !in_array($section, $sections) )
        $section = "accueil";
 ?>

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
	
	<title><?php if(isset($title)) echo $title; ?></title>
	<?php
	    echo Asset::css('BebasNeue.css');
	    echo Asset::css('DroidSans.css');
	    echo Asset::css('template.css');
        echo Asset::css('dialog_auth_msg.css');
	    echo Asset::css('cart.css');
	    if(isset($css_supp)) echo Asset::css($css_supp);
	    echo Asset::js('lib/jquery-latest.js');
	    echo Asset::js('lib/jquery.scrollTo-1.4.2-min.js');
	    echo Asset::js('lib/jquery.parallax-1.1.3.js');
	    echo Asset::js('lib/jquery.form.js');
	    echo Asset::js('lib/fbapi.js');
	    echo Asset::js('config.js');
	    echo Asset::js('template.js');
        echo Asset::js('cart.js');
        echo Asset::js('auth.js');
	    if(isset($js_supp)) echo Asset::js($js_supp);
	?>
	
<?php if( Auth::member(3) || Auth::member(5) ): ?>
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
    <div id="fb-root"></div>
    <script>
    // Load the SDK Asynchronously
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId=141570392646490";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Init the SDK upon load
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '141570392646490', // App ID
            channelUrl : 'http://season13.com/channelfile', // Path to your Channel File
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
        });
    }

    </script>
    
    <script type="text/javascript">
        window.current_section = "<?php echo $section; ?>";
        config.base_url = "http://"+window.location.hostname + (config.readerMode=="debug"?":8888":"") + config.publicRoot;
    </script>
    <?php 
        // output the javascript function
        echo Security::js_set_token(); 
    ?>

    <header>
        <div id="logo">
            <?php echo Asset::img('season13/13logo.png'); ?>
        </div>
        <a href="<?php echo $remote_path; ?>" id="logoLink" title="LOGO SEASON 13"></a>
        
        <ul id="menu">
            <li section="accueil"><a href="<?php echo $remote_path; ?>">ACCUEIL</a></li>
            <li class="text_sep_vertical"></li>
            <li section="episode"><a href="<?php echo $remote_path; ?>?s=episode">LES ÉPISODES</a></li>
            <li class="text_sep_vertical"></li>
            <li><a href="<?php echo $remote_path; ?>concept">LE CONCEPT</a></li>
            <li class="text_sep_vertical"></li>
            <li><a href="<?php echo $remote_path; ?>news">L'ACTU</a></li>
        </ul>
    </header>
    
    <ul id="conn">
<?php if($current_user == null): ?>
        <li id="open_signup">Créer un compte</li>
        <li class="text_sep_vertical"></li>
        <li id="open_login">Déjà client</li>
<?php else: ?>
    <?php if(Auth::member(100)): ?>
        <li><a href="admin/">ADMIN</a></li>
    <?php endif; ?>
        <li id="user_id">BIENVENUE: <?php echo $current_user->pseudo ?></li>
        <li class="text_sep_vertical"></li>
        <li id="logout">LOGOUT</li>
<?php endif; ?>
<!--
        <li class="text_sep_vertical"></li>
        <li id="cart"><?php echo Asset::img("season13/ui/cart.png") ?><span></span></li>
-->
    </ul>
    
<?php if($current_user == null): ?>
    <div id="signup_dialog" class="dialog">
        <div class="close"></div>
        <?php echo View::forge('auth/signup_form')->render(); ?>
    </div>
    <div id="login_dialog" class="dialog">
        <div class="close"></div>
        <?php echo View::forge('auth/login_form')->render(); ?>
    </div>
    <div id="change_pass_dialog" class="dialog">
        <div class="close"></div>
        <?php echo View::forge('auth/chpass_form')->render(); ?>
    </div>
    <div id="link_fb_dialog" class="dialog">
        <div class="close"></div>
        <?php echo View::forge('auth/linkFb_form')->render(); ?>
    </div>
    
<?php else: ?>
    <div id="update_dialog" class="dialog">
        <div class="close"></div>
        <?php echo View::forge('auth/update_form')->render(); ?>
    </div>
<?php endif; ?>
    
    <div id="cart_dialog" class="dialog">
        <div class="close"></div>
        <div class="cart_container">
            <?php echo View::forge('achat/cart/cart_view')->render(); ?>
        </div>
    </div>
    	    
<?php if(isset($content)) echo $content; ?>

	<footer>
	    <ul>
	        <li class="fb_btn">
                <div class="fb-like" data-href="<?php echo Uri::base(false).Uri::string(); ?>" data-send="false" data-layout="box_count" data-width="450" data-show-faces="false"></div>
	        </li>
	        <!--<li class="twitter_btn"></li>--></ul>
	    <div class="mask"></div>
		<p><a href="<?php echo $remote_path; ?>aboutus">Équipe</a> - <a href="<?php echo $remote_path; ?>thanksto">Remerciements</a> - <a href="<?php echo $remote_path; ?>contact">Contact</a> - <a href="<?php echo $remote_path; ?>mentionslegales">Mentions légales</a><!-- - <label>Conditions générales de vente</label>--></p>
	</footer>
</body>
</html>
