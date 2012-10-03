<!DOCTYPE html> 
<html lang="fr">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# encrenomade: http://ogp.me/ns/fb/encrenomade#">
<?php //$openGraph->printMeta(); ?>

<meta charset="UTF-8" />
<meta name="robots" content="noindex"/>
<meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>

<title>Encre Nomade Feuilletons</title>

<?php 
    echo Asset::css('story.css');
    echo Asset::js('lib/jquery-latest.js');
    echo Asset::js('lib/jquery.form.js');
    echo Asset::js('lib/BrowserDetect.js');
    echo Asset::js('lib/Interaction.js');
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

// Google Analytics
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30647659-1']);
  _gaq.push(['_setDomainName', 'encrenomade.com']);
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

<div id="root">
    <div id="loader"></div>
    <img id="newComment" src="./UI/tag_single.png" />
    <div id="menu">
        <ul>
            <li><div id="fb-custom-like" style="width: 32px;height: 30px;background: transparent url('./UI/facebook-like-icon.png') no-repeat left top;"></div></li>
            <li><img id="comment_btn" src="./UI/comment.png"></li>
        </ul>
        <img class="feuille" src="./UI/feuille.png">
    </div>
    <div id="comment">
        <img class="close" src="./UI/button/close.png"/>
        <div class="header">
            <img id="profilphoto" src="" />
            <img id="camera" src="./UI/camera.png" />
            <img id="user_draw" src="./UI/picture_up.png" />
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

</script>

</body>
</html>