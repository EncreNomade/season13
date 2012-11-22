<?php echo Asset::js('lib/swfobject.js'); ?>

<div class="main_container">

    <div id="back" class="layer">
        <?php echo Asset::img('season13/illus/petite_ceinture.jpg', array('alt' => 'Fond SEASON 13')); ?>
    </div>
    <div id="booktitle" class="layer">
        <?php echo Asset::img('season13/illus/titre_2.png', array('alt' => 'Voodoo Connection SEASON 13')); ?>
    </div>
    <div id="bookresume" class="layer">
        <!--<object width="420" height="236"><param name="movie" value="http://www.youtube.com/v/lwuMe5fzeyU?version=3&amp;hl=fr_FR"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/lwuMe5fzeyU?version=3&amp;hl=fr_FR&rel=0" type="application/x-shockwave-flash" width="420" height="236" allowscriptaccess="always" allowfullscreen="true"></embed></object>-->
        <div id="ytapiplayer">
            You need Flash player 8+ and JavaScript enabled to view this video.
        </div>
        <p>Simon, jeune orphelin, s’évade de son foyer, poursuivi par une bande : la Meute. Obligé de se réfugier dans les catacombes de Paris, il croise un sorcier vaudou et un inquiétant zombi...</p>
    </div>
    <div id="btns" class="layer">
        <ul>
            <!--<li id="open_login2"><a>SE CONNECTER</a></li>-->
            <li id="ep1"><a href="<?php echo $remote_path; ?>story?ep=1&source=discoverbtn" target="_blank">DÉCOUVRIR GRATUITEMENT</a></li>
        </ul>
    </div>
    
    <div id="episodes_section" class="layer">
        <div id="episodes">
            <div id="expos">
            <?php foreach ($admin_13episodes as $admin_13episode): ?>
                <?php if(!isset($current_ep)) $current_ep = $admin_13episode; ?>
                <div class="expo" 
                     data-id="<?php echo stripslashes($admin_13episode->id); ?>"
                     data-title="<?php echo stripslashes($admin_13episode->title); ?>"
                     data-episode="<?php echo $admin_13episode->episode; ?>"
                     data-bref="<?php echo stripslashes($admin_13episode->bref); ?>"
                     data-path="<?php echo $admin_13episode->path; ?>"
                     data-dday="<?php echo $admin_13episode->dday; ?>">
                     
                    <?php echo Html::img($admin_13episode->image); ?>
                    
                </div>
            <?php endforeach; ?>
            </div>
            
            <div class="ep_title">
                <h2><?php echo '#'.$current_ep->episode.'  '.stripslashes($current_ep->title); ?></h2>
                <a class="ep_play" target="_blank"></a>
                
                
            </div>
            
            <div class="ep_list">
            <!--
                <div id="ep_prev_btn">
                    <?php echo Asset::img("season13/ui/btn_left.jpg"); ?>
                </div>
            -->
                <ul>
                <?php foreach ($admin_13episodes as $admin_13episode): ?>
                    <?php if($current_ep == $admin_13episode): ?>
                    <li class="active"><?php echo '#'.$admin_13episode->episode; ?></li>
                    <?php else: ?>
                    <li><?php echo '#'.$admin_13episode->episode; ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            <!--
                <div id="ep_next_btn">
                    <?php echo Asset::img("season13/ui/btn_right.jpg"); ?>
                </div>
            -->
            </div>
        </div>
    </div>
    
</div>


<div id="simon" class="layer">
    <?php echo Asset::img('season13/illus/simonHD.png', array('alt' => 'Simon - SEASON 13')); ?>
</div>
<div id="bande4" class="layer">
    <?php echo Asset::img('season13/illus/bande4.png', array('alt' => 'Les 4 - SEASON 13')); ?>
</div>

<div class="center">
    <div id="invitation_dialog" class="dialog">
        <div class="close"></div>
        <h1>Invitation</h1>
    </div>
</div>