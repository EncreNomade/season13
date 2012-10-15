<!DOCTYPE html> 
<html lang="en">
<head>

<meta charset="UTF-8" />
<meta name="robots" content="noindex"/>
<meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, width=device-width, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>

<title><?php echo $title; ?></title>
<?php
    echo Asset::css('BebasNeue.css');
    echo Asset::css('story.css');
    echo Asset::js('lib/jquery-latest.js');
    echo Asset::js('lib/jquery.form.js');
    echo Asset::js('lib/BrowserDetect.js');
    echo Asset::js('lib/Tools.js');
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
</script>

</head>

<body>

    <header>
        <div id="tache">
            <?php echo Asset::img('story/story_tache.png'); ?>
        </div>
        <div id="sep_left"></div>
        <h1>Voodoo Connection</h1>
        
        <div id="icon_menu">
            <?php echo Asset::img('story/story_menu.png'); ?>
        </div>
        <div id="sep_right"></div>
        <div id="switch_menu"></div>
    </header>
    
    <ul id="menu">
        <li>
            <?php echo Asset::img('story/story_aide.png'); ?>
            <a>Aide</a>
        </li>
        <li>
            <?php echo Asset::img('story/story_author.png'); ?>
            <a>Auteur</a>
        </li>
        <li>
            <?php echo Asset::img('story/story_param.png'); ?>
            <a>Paramètres</a>
        </li>
        <li>
            <?php echo Asset::img('story/story_download.png'); ?>
            <a>Téléchargement</a>
        </li>
        <li>
            <?php echo Asset::img('story/story_credit.png'); ?>
            <a>Crédits</a>
        </li>
        
        <?php echo Html::img('assets/img/logo_white.png', array("id" => "menu_logo")); ?>
        <?php echo Html::anchor('http://season13.com', 'www.season13.com', array("id" => "menu_link", "target" => "_blank")); ?>
    </ul>

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