<!DOCTYPE html> 
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# encrenomade: http://ogp.me/ns/fb/encrenomade#">

<meta property="fb:app_id" content="141570392646490" /> 
<meta property="og:type"   content="encrenomade:episode" /> 
<meta property="og:url"    content="<?php echo Uri::current(); ?>" /> 
<meta property="og:title"  content="<?php echo stripcslashes( $episode->story." Episode ".$episode->episode.": ".$episode->title ); ?>" /> 
<meta property="og:image"  content="http://season13.com/voodoo/cover.jpg" />

<meta charset="UTF-8" />
<meta name="robots" content="noindex"/>
<meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, width=device-width, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>

<title><?php echo $title; ?></title>

<!-- Script for integrate the font: Helvetica Ultra Compressed
    <script type="text/javascript" src="http://fast.fonts.com/jsapi/11bfc142-9579-4cac-b6a6-2a561db23028.js"></script>
-->

<!--<link rel="stylesheet" href="/assets/font/gudea/stylesheet.css" type="text/css">-->

<link href='http://fonts.googleapis.com/css?family=Gudea:400,700,400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

<?php
    echo Asset::css('BebasNeue.css');
    echo Asset::css('DroidSans.css');
    echo Asset::css('story.css');
    echo Asset::js('lib/jquery-latest.js');
    echo Asset::js('lib/jquery.form.js');
    echo Asset::js('lib/BrowserDetect.js');
    echo Asset::js('lib/Tools.js');
    echo Asset::js('lib/Interaction.js');
    echo Asset::js('lib/fbapi.js');
    echo Asset::js('config.js');
    echo Asset::js('story/msg_center.js');
    echo Asset::js('story/gui.js');
    echo Asset::js('story/scriber.js');
    echo Asset::js('story/events.js');
    echo Asset::js('story/mse.js');
    echo Asset::js('story/effet_mini.js');
    echo Asset::js('story/mdj.js');
?>

<script type="text/javascript">
addEventListener("load", function(){
	setTimeout(function(){window.scrollTo(0, 1);}, 0);
	$('body').css({'margin':'0px','padding':'0px'});
}, false);
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35640835-1']);
  _gaq.push(['_setDomainName', 'season13.com']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<body>

    <div id="fb-root"></div>
    <script>
        // Load the SDK Asynchronously
        (function(d){
            var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement('script'); js.id = id; js.async = true;
            js.src = "//connect.facebook.net/fr_FR/all.js";
            ref.parentNode.insertBefore(js, ref);
        }(document));
        
        
        // Init the SDK upon load
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '141570392646490', // App ID
                channelUrl : 'http://testfb.encrenomade.com/channelfile', // Path to your Channel File
                status     : true, // check login status
                cookie     : true, // enable cookies to allow the server to access the session
                xfbml      : true  // parse XFBML
            });
            
            fbapi.checkConnect();
        }
    </script>

    <div id="msgCenter"><ul></ul></div>

    <header>
        <div class="left">
            <div id="tache">
                <?php echo Asset::img('story/story_tache.png'); ?>
            </div>
            <div id="sep_left"></div>
            <h1>Voodoo Connection</h1>
        </div>
        
        <div class="right">
            <div id="icon_menu">
                <?php echo Asset::img('story/story_menu.png'); ?>
            </div>
            <div id="sep_right"></div>
            <div id="switch_menu"></div>
        </div>
    </header>
    
    <ul id="menu">
        <!--<li id="btn_aide">
            <?php echo Asset::img('story/story_aide.png'); ?>
            <a>Aide</a>
        </li>-->
        <li id="btn_param">
            <?php echo Asset::img('story/story_param.png'); ?>
            <a>Paramètres</a>
        </li>
        <li id="btn_author">
            <?php echo Asset::img('story/story_author.png'); ?>
            <a>Auteur</a>
        </li>
        <!--<li id="btn_download">
            <?php echo Asset::img('story/story_download.png'); ?>
            <a>Téléchargement</a>
        </li>-->
        <li id="btn_credit">
            <?php echo Asset::img('story/story_credit.png'); ?>
            <a>Crédits</a>
        </li>
        
        <div>
            <?php echo Html::img('assets/img/logo_white.png', array("id" => "menu_logo")); ?>
            <?php echo Html::anchor('http://season13.com', 'www.season13.com', array("id" => "menu_link", "target" => "_blank")); ?>
        </div>
    </ul>
    
    <div id="center">
    <!-- Preferece dialog -->
        <div id="preference" class="dialog">
            <div class="close"></div>
            <h1>Paramètres</h1>
            <div class="sep_line"></div>
            <p>Audio: </p>
            <p>Vitesse: </p>
            <p>Partager les commentaires sur facebook: <input type="checkbox" checked="true"></p>
        </div>
        
        
    <!-- Comment dialog -->
        <div id="comment" class="dialog">
            <div class="close"></div>
            <h1>Commentaires</h1>
            <div class="sep_line"></div>
            
            <textarea id="comment_content" rows="5" cols="30" placeholder="Exprime-toi !"></textarea>
            <div class="arrow"></div>
            <ul id="comment_menu">
                <li id="btn_share" title="Partage ton commentaire">
                    <?php if(!is_null($current_user) && ($current_user->fbid != "" && $current_user->fbid != 0)) : ?>
                        <?php echo Asset::img('story/comment_fb.png'); ?>
                    <?php endif; ?>
                    <h5>Partager</h5>
                </li>
                <li id="btn_upload_img" title="Télécharge ton propre dessin">
                    <?php echo Asset::img('story/comment_image.png'); ?>
                </li>
                <li id="btn_capture_img" title="Capture une image dans l'épisode">
                    <?php echo Asset::img('story/comment_camera.png'); ?>
                </li>
            </ul>
            
            <div id="upload_container">
                <div class="arrow"></div>
                <form id="imageuploadform" method="POST" enctype="multipart/form-data" action='/seasion13/public/upload'>
                    <input type="file" name="upload_pic" id="upload_pic" />
                    <input type="button" value="Télécharge ton dessin" id="upload_btn" />
                </form>
            </div>
            
            <ul id="comment_list">
            
                <h5 id='renew_comments' style="cursor: pointer;">Clique pour voir les anciens commentaires</h5>
            </ul>
            
            <div class="loading"></div>
        </div>
        
        
    <!-- Scriber dialog -->
        <div id="scriber" class="dialog">
            <div class="close" id="sb_cancel"></div>
            <h1>Customise ton dessin</h1>
            <div class="sep_line"></div>
            
            <div id="toolbox">
                <ul id="sb_tools">
                    <li id="sb_pencil">
                        <?php echo Asset::img('ui/scriber_edit.png'); ?>
                        <h5>Dessiner</h5>
                        
                        <ul id="sb_colorset">
                            <span>Couleur</span>
                            <li class="active" id="sb_black" style="background: #201b21;"></li>
                            <li id="sb_red" style="background: #ef1c22;"></li>
                            <li id="sb_orange" style="background: #f77100;"></li>
                            <li id="sb_yellow" style="background: #ffdf1a;"></li>
                            <li id="sb_green" style="background: #21d708;"></li>
                            <li id="sb_blue" style="background: #0182e7;"></li>
                            <li id="sb_purple" style="background: #914ce4;"></li>
                        </ul>
                        <ul id="sb_sizeset">
                            <span>Epaisseur</span>
                        
                            <canvas id="sb_sizes_canvas" width="149" height="31"></canvas>
                            <div id="sb_sizebloc"></div>
                        </ul>
                    </li>
                    <li id="sb_eraser">
                        <?php echo Asset::img('ui/scriber_erase.png'); ?>
                        <h5>Effacer</h5>
                    </li>
                    <!--<li id="sb_resize">
                        <?php echo Asset::img('ui/scriber_resize.png'); ?>
                        <h5>Redimensionner</h5>
                    </li>-->
                </ul>
            </div>
            
            <div class="canvas_container">
                <div class="inner_container">
                    <canvas id="sb_imgcanvas"></canvas>
                    <canvas id="sb_drawcanvas"></canvas>
                </div>
                <div id="circle_center">
                    <div class="circle"></div>
                    <div class="moveicon editicon"></div>
                    <div class="dragicon editicon"></div>
                    <div class="deleteicon editicon"></div>
                </div>
                <!--<img class="resize" src="./UI/button/resize.png" draggable="false">-->
            </div>
            
            <ul id="scriber_menu">
                <li id="sb_edit" title="Modifie l'image"><?php echo Asset::img('ui/scriber_edit.png'); ?></li>
                <div class="sep_line"></div>
                <li id="sb_recap" title="Recommence"><?php echo Asset::img('ui/scriber_recap2.png'); ?></li>
                <div class="sep_line"></div>
                <li id="sb_confirm" title="Valide ton dessin"><?php echo Asset::img('ui/scriber_confirm.png'); ?></li>
            </ul>
        </div>
    </div>
    
    
    <div id="root">
        <div id="controler">
            <div class="back"></div>
            <div id="circle">
                <?php echo Asset::img('ui/controler_config.png'); ?>
                <span></span>
            </div>
            
            <ul>
                <li id="ctrl_like"><?php echo Asset::img('ui/wheel_like2.png'); ?></li>
                <li id="ctrl_speedup"><?php echo Asset::img('ui/wheel_rabbit.png'); ?></li>
                <li id="ctrl_playpause"><?php echo Asset::img('ui/wheel_pause.png'); ?></li>
                <li id="ctrl_slowdown"><?php echo Asset::img('ui/wheel_turtle.png'); ?></li>
                <li id="ctrl_comment"><?php echo Asset::img('ui/wheel_comment.png'); ?></li>
            </ul>
        </div>
    
        <canvas class="bookroot">Votre navigateur ne supporte pas HTML5</canvas>
        <div class="video"></div>
        <div id="imgShower"><div>
                <img id="theImage" src=""/>
                <?php echo Html::img('assets/img/story/button/close.png', array("id" => "closeBn")); ?>
        </div></div>
        
        <div id="game_container" class="dialog">
            <h1></h1>
            <div class="sep_line"></div>
            
            <canvas id="gameCanvas" class='game' width=50 height=50></canvas>
            
            <div id="game_center">
                <div id="game_result">
                    <?php echo Asset::img('fb_btn.jpg'); ?>
                    <h2>GAGNE !</h2>
                    <h5>Ton score : <span>240</span> pts</h5>
                    <ul>
                        <li id="game_restart">REJOUER</li>
                        <li id="game_quit">QUITTER</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    
    <script type="text/javascript">
    <?php 
        
        echo "mse.configs.epid = ".$episode->id.";\n\t";
        echo "mse.configs.srcPath = '".$episode->path."';\n\t";
        $content = file_get_contents($episode->path."content.js");
        echo $content;
    
    ?>
    </script>

</body>
</html>