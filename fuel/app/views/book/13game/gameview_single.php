<style type="text/css">
    #single_game_shower {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.78);
        display: none;
        z-index: 30;
    }
    #single_game_shower iframe {
        border: none;
        width: 100%;
        height: 100%;
    }
</style>


<div id="single_game_shower"><iframe src="about:blank"></iframe></div>
<div class="main_container">
    <div class="container_center">
        <div id="single_game_info" class="dialog">
            <h1><a href="<?php echo $base_url; ?>games">Les Jeux</a> > <?php echo $game->episode->episode.". ".$game->name; ?></h1>
            <div class="sep_line"></div>
            
        <?php if(!isset($current_user)): ?>
            <p class="center_text">Si tu n’es pas encore inscrit, débloque d’abord le 1er jeu dans l’épisode 1.</p>
        <?php endif; ?>
            
            <?php echo Asset::img($game->expo, array('class' => 'expo')); ?>
                        
        <?php if(!isset($current_user)): ?>
            <a id="discoverbtn" href="<?php echo $base_url; ?>Voodoo_Connection/season1/episode1?utm_source=game_discoverbtn&utm_medium=cpc" target="_blank" class="right">
                <?php echo Asset::img('season13/btn_discover.png', array('alt' => 'Découvrir 1er jeu dans 1er episode')); ?>
                <h5>DECOUVRE GRATUITEMENT LE 1ER JEU</h5>
            </a>
            
            <p id="connect" class="right center_text">Déjà inscrit ? <a href="javascript:showLogin();">CONNECTE-TOI</a></p>
            
        <?php else: ?>
            <div class="play right">
                <?php if( $game->episode->hasAccess($current_user) ): ?>
                    <?php if($current_user->havePlayed($game->id)): ?>
                        <button class="game_link playBtn" data-gameClass="<?php echo $game->class_name; ?>">Jouer</button>
                    <?php else: ?>
                        <p>
                            Tu dois avoir joué au moins une fois à ce jeu en lisant l'épisode :  
                            <b><?php echo Html::anchor($game->episode->getRelatLink(), stripslashes($game->episode->title)); ?></b>
                            .
                        </p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Pour jouer tu dois possèdez l'épisode : <b><?php echo $game->episode->title; ?></b>.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
            
            <div class="right">
                <div id="section_line"></div>
            </div>
            
            <?php if(!empty($gameInfos)): ?>
                <div class="classement right">
                    <?php echo View::forge('book/13game/classement')->render(); ?>
                </div>
            <?php endif; ?>
            <div class="clear"></div>
        </div>
    </div>
</div>
