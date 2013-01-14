<?php echo Asset::js('lib/swfobject.js'); ?>

<a id="furet" href="<?php echo $remote_path; ?>concept">
    Coup de coeur<?php echo Asset::img('season13/furet_logo.jpg', array('alt' => 'Coup de coeur du Furet du nord - SEASON 13')); ?>
</a>

<div class="main_container">

    <div id="back" class="layer">
        <?php echo Asset::img('season13/illus/petite_ceinture.jpg', array('alt' => 'Fond SEASON 13')); ?>
    </div>
    <div id="booktitle" class="layer">
        <a href="<?php echo $remote_path; ?>Voodoo_Connection/season1/episode1?source=discoverbtn">
            <?php echo Asset::img('season13/btn_discover.png', array('alt' => 'Découvrir 1er épisode de Voodoo Connection')); ?>
            <h5>LANCE-TOI GRATUITEMENT DANS L'HISTOIRE</h5>
        </a>
    </div>
    <div id="bookresume" class="layer">
        <!--<object width="420" height="236"><param name="movie" value="http://www.youtube.com/v/lwuMe5fzeyU?version=3&amp;hl=fr_FR"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/lwuMe5fzeyU?version=3&amp;hl=fr_FR&rel=0" type="application/x-shockwave-flash" width="420" height="236" allowscriptaccess="always" allowfullscreen="true"></embed></object>-->
        <div id="ytapiplayer">
            You need Flash player 8+ and JavaScript enabled to view this video.
        </div>
        <div id="resumebody">
            <?php echo Asset::img('season13/illus/titre_2.png', array('alt' => 'Voodoo Connection SEASON 13')); ?>
            <p>Simon, jeune orphelin, s’évade de son foyer, poursuivi par une bande : la Meute. Obligé de se réfugier dans les catacombes de Paris, il croise un sorcier vaudou et un inquiétant zombi...</p>
        </div>
    </div>
    <div id="btns" class="layer">
        <ul>
            <!--<li id="open_login2"><a>SE CONNECTER</a></li>-->
            <li id="ep1"><a href="<?php echo $remote_path; ?>Voodoo_Connection/season1/episode1?source=discoverbtn" target="_blank">DÉCOUVRIR GRATUITEMENT</a></li>
        </ul>
    </div>
    
    <div id="episodes_section" class="layer">
        <div id="episodes">
            <div id="expos">
            <?php foreach ($admin_13episodes as $admin_13episode): ?>
                <?php if(!isset($current_ep)) $current_ep = $admin_13episode; ?>
                <div class="expo" 
                     data-id="<?php echo stripslashes($admin_13episode->id); ?>"
                     data-story="<?php echo stripslashes(str_replace(' ', '_', $admin_13episode->story)); ?>"
                     data-title="<?php echo stripslashes($admin_13episode->title); ?>"
                     data-season="<?php echo stripslashes($admin_13episode->season); ?>"
                     data-episode="<?php echo $admin_13episode->episode; ?>"
                     data-price="<?php echo $admin_13episode->price; ?>"
                     data-bref="<?php echo stripslashes($admin_13episode->bref); ?>"
                     data-path="<?php echo $admin_13episode->path; ?>"
                     data-dday="<?php echo $admin_13episode->dday; ?>">
                     
                    <?php echo Html::img($admin_13episode->image); ?>
                </div>
            <?php endforeach; ?>
            </div>
            
            <div class="ep_title">
                <h2>
                    <?php echo '#'.$current_ep->episode.'  '.stripslashes($current_ep->title); ?>
                    <span><?php if($current_ep->price != "") echo $current_ep->price.'€'; ?></span>
                </h2>
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
<!--
<div id="bande4" class="layer">
    <?php echo Asset::img('season13/illus/bande4.png', array('alt' => 'Les 4 - SEASON 13')); ?>
</div>-->

<div class="center">
    <div id="access_dialog" class="dialog">
        <div class="close"></div>
        <h1></h1>
        <div class="sep_line"></div>
    </div>
</div>