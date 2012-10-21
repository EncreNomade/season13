<!DOCTYPE html> 
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# encrenomade: http://ogp.me/ns/fb/encrenomade#">

<meta property="fb:app_id" content="141570392646490" /> 
<meta property="og:type"   content="encrenomade:episode" /> 
<meta property="og:url"    content="<?php echo Uri::current(); ?>" /> 
<meta property="og:title"  content="<?php echo stripcslashes( $episode->story." ".$episode->title ); ?>" /> 
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

<?php
    echo Asset::css('BebasNeue.css');
    echo Asset::css('DroidSans.css');
    echo Asset::css('story.css');
    echo Asset::js('lib/jquery-latest.js');
    echo Asset::js('lib/jquery.form.js');
    echo Asset::js('lib/BrowserDetect.js');
    echo Asset::js('lib/Tools.js');
    echo Asset::js('lib/Interaction.js');
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
            
            gui.fb.checkConnect();
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
        <li id="btn_aide">
            <?php echo Asset::img('story/story_aide.png'); ?>
            <a>Aide</a>
        </li>
        <li id="btn_author">
            <?php echo Asset::img('story/story_author.png'); ?>
            <a>Auteur</a>
        </li>
        <li id="btn_param">
            <?php echo Asset::img('story/story_param.png'); ?>
            <a>Paramètres</a>
        </li>
        <li id="btn_download">
            <?php echo Asset::img('story/story_download.png'); ?>
            <a>Téléchargement</a>
        </li>
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
        <div id="preference" class="dialog">
            <div class="close"></div>
            <h1>Paramètres</h1>
            <div class="sep_line"></div>
            <p>Audio: </p>
            <p>Vitesse: </p>
            <p>Partager les commentaires sur facebook: <input type="checkbox" checked="true"></p>
        </div>
        
        <div id="comment" class="dialog">
            <div class="close"></div>
            <h1>Commentaires</h1>
            <div class="sep_line"></div>
            
            <textarea id="comment_content" rows="5" cols="30" placeholder="Exprime toi !"></textarea>
            <div class="arrow"></div>
            <ul id="comment_menu">
                <li id="btn_share" title="Partager votre commentaire"><?php echo Asset::img('story/comment_fb.png'); ?><h5>Partager</h5></li>
                <li id="btn_upload_img" title="Télécharger vos propres dessins"><?php echo Asset::img('story/comment_image.png'); ?></li>
                <li id="btn_capture_img" title="Capturer une image dans le livre"><?php echo Asset::img('story/comment_camera.png'); ?></li>
            </ul>
            
            <div id="upload_container">
                <div class="arrow"></div>
                <form id="imageuploadform" method="POST" enctype="multipart/form-data" action='/seasion13/public/upload'>
                    <input type="file" name="upload_pic" id="upload_pic" />
                    <input type="button" value="Télécharge ton dessin" id="upload_btn" />
                </form>
            </div>
            
            <ul id="comment_list">
            
                <h5 id='renew_comments' style="cursor: pointer;">Cliquer pour voir les anciens commentaires</h5>
            </ul>
            
            <div class="loading"></div>
        </div>
    </div>
    
    
    <div id="root">
        <div id="controler">
            <div class="back"></div>
            <div id="circle"></div>
            
            <ul>
                <li id="ctrl_speedup"><?php echo Asset::img('ui/wheel_turtle.png'); ?></li>
                <li id="ctrl_slowdown"><?php echo Asset::img('ui/wheel_rabbit.png'); ?></li>
                <li id="ctrl_playpause"><?php echo Asset::img('ui/wheel_pause.png'); ?></li>
                <li id="ctrl_comment"><?php echo Asset::img('ui/wheel_comment.png'); ?></li>
                <li id="ctrl_like"><?php echo Asset::img('ui/wheel_like.png'); ?></li>
            </ul>
        </div>
    
        <canvas class="bookroot">Votre navigateur ne supporte pas HTML5</canvas>
        <div class="video"></div>
        <div id="imgShower"><div>
                <img id="theImage" src=""/>
                <?php echo Html::img('assets/img/story/button/close.png', array("id" => "closeBn")); ?>
        </div></div>
        <canvas id="gameCanvas" class='game' width=50 height=50></canvas>
    </div>
    
    
    <script type="text/javascript">
    <?php 
        
        echo "mse.configs.epid = ".$episode->id.";\n\t";
        echo "mse.configs.srcPath = 'voodoo/ep1/';\n\t";
        $content = file_get_contents("voodoo/ep1/content.js");
        echo $content;
    
    ?>
    </script>

<!--
<div id="root">
    <div id="msgCenter"><ul></ul></div>
    <div id="loader"></div>
    <?php echo Html::img('assets/img/story/tag_single.png', array("id" => "newComment")) ?>
    <div id="menu">
        <ul>
            <li><div style="width: 32px;height: 30px;background: transparent"><?php echo Html::img('assets/img/story/facebook-like-icon.png') ?></div></li>
            <li><?php echo Html::img('assets/img/story/comment.png', array("id" => "comment_btn")) ?></li>
            <li><?php echo Html::img('assets/img/story/settings.png', array("id" => "preference_btn")) ?></li>
        </ul>
        <?php echo Html::img('assets/img/story/feuille.png', array("class" => "feuille")) ?>
    </div>
    <div id="comment">
        <?php echo Html::img('assets/img/story/button/close.png', array("class" => "close")) ?>
        <div class="header">
            <img id="profilphoto" src="" />
            <?php echo Html::img('assets/img/story/camera.png', array("id" => "camera")) ?>
            <?php echo Html::img('assets/img/story/picture_up.png', array("id" => "user_draw")) ?>
            <img id="comment_image" src="" />
            <div id="upload_container">
                <div class="arrow"></div>
                <form id="imageuploadform" method="post" enctype="multipart/form-data" action='../upload_user_draw.php'>
                    <input type="file" name="upload_pic" id="upload_pic" />
                    <input type="button" value="Télécharger" id="upload_btn" />
                </form>
            </div>
            <a id="share" class="facebook">Partager</a>
        </div>
        <div class="body">
            <textarea id="comment_content" rows="5" cols="30" placeholder="Écrire votre commentaire ici..."></textarea>
            <div class="users_comments">
                <h5 class='renew_comments'>Cliquer pour voir les anciens commentaires</h5>
            </div>
        </div>
    </div>
    <div id="center">
        <div id="scriber">
            <div class="toolbox">
                <div class="anchor"></div>
                <ul>
                    <li><img id="sb_img" src="./UI/config_img.gif"/></li>
                    <li class="active"><img id="sb_pencil" src="./UI/pencil_nocolor.png"/>
                        <ul id="sb_colorset" class="sb_subtool">
                            <li class="active"><img id="sb_black" src="./UI/color/black.png"></li>
                            <li><img id="sb_red" src="./UI/color/red.png"></li>
                            <li><img id="sb_orange" src="./UI/color/orange.png"></li>
                            <li><img id="sb_yellow" src="./UI/color/yellow.png"></li>
                            <li><img id="sb_green" src="./UI/color/green.png"></li>
                            <li><img id="sb_blue" src="./UI/color/blue.png"></li>
                            <li><img id="sb_purple" src="./UI/color/purple.png"></li>
                        </ul>
                    </li>
                    <li><img id="sb_eraser" src="./UI/eraser.png"/></li>
                    <li><canvas id="sb_size" width="32" height="32"></canvas>
                        <canvas id="sb_sizeset" class="sb_subtool" width="32" height="200"></canvas>
                        <div id="sb_sizebloc"></div>
                    </li>
                    <li><img id="sb_confirm" src="./UI/ok.png"/></li>
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
                <img class="close" src="./UI/button/close.png"/>
                <img class="resize" src="./UI/button/resize.png" draggable="false">
            </div>
        </div>
        <div id="capture_result">
            <canvas id="sb_canvas"></canvas>
            <div id="util">
                <img id="confirm" src="./UI/confirm.png"/>
                <img id="edit" src="./UI/edit.png">
                <img id="recapture" src="./UI/recapture.png">
                <img id="close" src="./UI/cancel.png">
            </div>
        </div>
        <div id="preference">
            <img class="close" src="./UI/button/close.png"/>
            <p>Audio: </p>
            <p>Vitesse: </p>
            <p>Partager les commentaires sur facebook: <input type="checkbox" checked="true"></p>
            <input type="button" value="Aide"/>
            <input type="button" value="Auteur"/>
            <input type="button" value="Crédit"/>
        </div>
    </div>
    <canvas class="bookroot">Votre navigateur ne supporte pas HTML5</canvas>
    <div class="video"></div>
    <div id="imgShower"><div>
            <img id="theImage" src=""/>
            <img id="closeBn"  src="UI/button/close.png"/>
    </div></div>
    <canvas id="gameCanvas" class='game' width=50 height=50></canvas>
</div>

<script type="text/javascript">
<?php 



?>
</script>
-->

</body>
</html>