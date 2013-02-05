
<div class="main_container">
    <header>
        <p>
            Découvre les épisodes pour débliquer les jeux:
        </p>
    </header>

    <section>
    <?php 
    $count = 0;
    foreach($games as $game): 
        $count++;
        $episode = $game->episode; 
    ?>
        <article>
            <h1><?php echo $count.". ".$game->name; ?></h1>
            
            <div class="expo">
                <?php echo Asset::img($game->expo, array('class' => 'expoimage')); ?>
                
                <?php if(!$game->access): ?>
                <a href="<?php echo $base_url . str_replace(' ', '_', $episode['story']) . "/season" . $episode['season'] . "/episode" . $episode['episode']; ?>" class="mask">
                    
                    <?php echo Asset::img('season13/ui/lock1.png', array("class" => "lock")); ?>
                    <?php echo Asset::img('season13/ui/key1.png', array("class" => "key")); ?>
                    <p>
                        Découvre l'épisode <?php echo $episode['episode']; ?>
                    </p>
                </a>
                    
                <?php else: ?>
                
                <a href="<?php echo $base_url."book/gameview/info/".$game->class_name; ?>" class="mask">
                    <?php echo Asset::img('season13/ui/btn_play.png', array("class" => "play")); ?>
                </a>
                
                <?php endif; ?>
                
            </div>
            
        </article>
    <?php endforeach; ?>
    </section>
    
</div>
