<?php 
    $likeUrl = $base_url . "games/" . $game->class_name;
?>

<html>
<head>
    <title>Single Game</title>

    <meta charset="utf-8">
    <meta name="Description" content="<?php if( isset($description) ) echo $description; else echo "Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web: Voodoo Connection";  ?>" />
    
    <meta property="og:title" content="SEASON13" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $likeUrl; ?>" />
    <meta property="og:image" content="http://season13.com/voodoo/cover.jpg" />
    <meta property="og:site_name" content="SEASON13.com" />
    <meta property="og:description" content="<?php if( isset($description) ) echo $description; else echo "Suspense, mystère, aventures, découvrez une nouvelle expérience interactive sur le web.";  ?>" />
    <meta property="fb:app_id" content="141570392646490" />   
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link href='http://fonts.googleapis.com/css?family=Gudea:400,700,400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <?php 
        echo Asset::css('dialog_auth_msg.css');
        echo Asset::css('story.css');
        echo Asset::css('BebasNeue.css');
     ?>

    <?php 
        // JQuery
        echo Asset::js('lib/jquery-1.9.1.min.js');
    
        // Other JS lib public
        echo Asset::js('lib/jquery.form.min.js');
        echo Asset::js('lib/BrowserDetect.min.js');
        
        // Config files
        echo Asset::js('config.js');
        
        // Lib
        if(Fuel::$env == Fuel::DEVELOPMENT || Fuel::$env == Fuel::TEST) {
            echo Asset::js('lib/Tools.js');
            echo Asset::js('lib/Interaction.js');
            echo Asset::js('lib/fbapi.js');
            echo Asset::js('cart.js');
            echo Asset::js('auth.js');
            echo Asset::js('story/msg_center.js');
            echo Asset::js('story/gui.js');
        
            echo Asset::js('story/gameinfo.js');
            echo Asset::js('story/tuto.js');
            echo Asset::js('story/scriber.js');
            echo Asset::js('story/events.js');
            echo Asset::js('story/mse.js');
            echo Asset::js('story/effet_mini.js');
            echo Asset::js('story/mdj.js');
        }
        else {
            echo Asset::js('story/lib.min.js');
            echo Asset::js('story/core.min.js');
        }

    ?>
    <script src="<?php echo $base_url."$path/games/$fileName"; ?>"></script>

    <style type="text/css">
        img#close_game_icon {
            position: absolute;
            top: -60px;
            right: -30px;
            cursor: pointer;
        }
        .like-container {
            position: absolute;
            top: -30px;
            right: 20px;
        }
    </style>

</head>
<body>
    <div id="fb-root"></div>
    <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
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
    
    </script>


    <div id="game_container" class="dialog">
        <h1></h1>
        <div class="like-container"><div class="fb-like" data-href="<?php echo $likeUrl ?>" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false"></div></div>
        <div class="sep_line"></div>
        <?php echo Asset::img('season13/ui/btn_close.png', array('id'=> 'close_game_icon')) ?>        
        <canvas id="gameCanvas" class='game' width=50 height=50></canvas>
        
        <div id="game_center">
            <div id="game_result">
                <?php echo Asset::img('season13/fb_btn.jpg', array('alt' => 'Partager ton score sur Facebook')); ?>
                <h2>Bravo! <span>240</span> pts    </h2>
                <h5>Améliore ton <br/>classement ! </h5>
                <ul>
                    <li id="game_restart">REJOUER</li>
                    <li id="game_quit">QUITTER</li>
                </ul>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        config.base_url = "http://"+window.location.hostname + (config.readerMode=="debug"?":8888":"") + config.publicRoot;
        
        config.episode = {};
        config.episode.gameExpos = {};
        config.episode.gameExpos["<?php echo $game->class_name; ?>"] = "<?php echo Asset::get_file($game->expo, 'img'); ?>";
        
        if(window.parent.gameNotifier) {
            var gameNotifier = window.parent.gameNotifier;
            
            $(function(){
                $('#game_quit, #close_game_icon').click(gameNotifier.quit);
            });
            
            window.initMseConfig();
            mse.init(null, null, $(window.parent.document).width(), $(window.parent.document).height());
            mse.currTimeline.start();
            
            mse.configs.srcPath='<?php echo Uri::base(false) . "$path/" ?>';
            window.game = new <?php echo $className ?>();
            game.config.indep = true;
            
            var book = $('.bookroot');
            if(book.length > 0) book.hide(0);
            // game.start();

        }
    </script>
</body>
</html>



