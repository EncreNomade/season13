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
    <div id="single_game_info">
        <h1><?php echo $game->name; ?></h1>
        <?php echo Asset::img($game->expo, array('class' => 'expo')); ?>
        <div class="info right">
            <p><?php echo $game->presentation; ?></p>
            <?php if($game->instruction): ?>
                <p class="instruction">
                    Instruction :<br>
                    <?php echo $game->instruction; ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="play right">  
            <?php if(isset($current_user)): ?>    
                <?php if( $game->episode->hasAccess($current_user) ): ?>
                    <?php if($current_user->havePlayed($game->id)): ?>
                        <button class="game_link playBtn" data-gameClass="<?php echo $game->class_name; ?>">Jouer</button>      
                    <?php else: ?>
                        <p>
                            Tu dois avoir joué au moins une fois à ce jeu en lisant l'épisode :  
                            <b><?php echo Html::anchor($game->episode->getRelatLink(), $game->episode->title); ?></b>
                            .
                        </p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Pour jouer tu dois possèdez l'épisode : <b><?php echo $game->episode->title; ?></b>.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>tu dois être inscrit et connecté pour jouer ici.</p>                
            <?php endif; ?> 
        </div>     
        <div class="clear"></div>  
    </div>
</div>
