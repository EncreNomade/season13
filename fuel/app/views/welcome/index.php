<?php echo Asset::js('lib/swfobject.js'); ?>

<a id="furet" href="<?php echo $remote_path; ?>concept">
    Coup de coeur<?php echo Asset::img('season13/furet_logo.jpg', array('alt' => 'Coup de coeur du Furet du nord - SEASON 13')); ?>
</a>

<div class="main_container">

    <div id="back" class="layer">
        <?php echo Asset::img('season13/illus/petite_ceinture.jpg', array('alt' => 'Fond SEASON 13')); ?>
    </div>
    <div id="booktitle" class="layer">
        <a href="<?php echo $remote_path; ?>Voodoo_Connection/season1/episode1?source=discoverbtn" target="_blank">
            <?php echo Asset::img('season13/btn_discover.png', array('alt' => 'Découvrir 1er épisode de Voodoo Connection')); ?>
            <h5>LANCE-TOI GRATUITEMENT DANS L'HISTOIRE</h5>
        </a>
    </div>
    <div id="bookresume" class="layer">
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
            <li id="ep1"><a href="<?php echo $remote_path; ?>Voodoo_Connection/season1/episode1?source=discoverbtn" target="_blank">DÉCOUVRIR GRATUITEMENT</a></li>
        </ul>
    </div>
    
    <div id="episodes_section" class="layer">
        <div id="episodes">
            <div id="expos">
            <?php foreach ($episodes as $ep): ?>
            
                <div class="expo" 
                     data-id="<?php echo stripslashes($ep->id); ?>"
                     data-story="<?php echo stripslashes(str_replace(' ', '_', $ep->story)); ?>"
                     data-title="<?php echo stripslashes($ep->title); ?>"
                     data-season="<?php echo stripslashes($ep->season); ?>"
                     data-episode="<?php echo $ep->episode; ?>"
                     data-price="<?php echo $ep->price; ?>"
                     data-bref="<?php echo stripslashes($ep->bref); ?>"
                     data-path="<?php echo $ep->path; ?>"
                     data-dday="<?php echo $ep->dday; ?>">
                     
                    <?php 
                        $info = $supp[$ep->id];
                        $product = $info['product'];
                        if(!isset($current_ep)) $current_ep = $ep; 
                    ?>
                    <div class="ep_img<?php if(!$info['available']) echo " indispo"; ?>">
                         
                        <?php echo Html::img($ep->image); ?>
                    </div>
                    
                    <div class="ep_title">
                        <h2>
                            <?php echo '#'.$ep->episode.'  '.stripslashes($ep->title); ?>
                            <span>
                                <?php 
                                if(!$info['access'] && $product) {
                                    $price = $product->getLocalPrice();
                                    if($price > 0)
                                        echo $price.'€'; 
                                }
                                 ?>
                            </span>
                        </h2>
                    
                    <?php if(!$info['available']): // Indisponible ?>
                    
                        <a class="ep_play" href="#">Disponible le <?php echo Date::create_from_string($ep->dday, '%Y-%m-%d')->format("%d/%m"); ?></a>
                        
                    <?php elseif($info['access']): // Has access ?>
                    
                        <a class="ep_play" href="<?php echo $info['link']; ?>" target="_blank">VOIR L'ÉPISODE</a>
                    
                    <?php elseif(empty($product)): // No product, free ?>
                    
                        <a class="ep_play" href="<?php echo $info['link']; ?>" target="_blank">VOIR L'ÉPISODE</a>
                    
                    <?php else: // Buy Product  ?>
                    
                        <?php if($ep->id <= 4): ?>
                            <a class="ep_play" href="#">VOIR L'ÉPISODE</a>
                        <?php else: ?>
                            <!--<a class="ep_play" href="javascript:cart.add('')">ACHETER</a>-->
                            <a class="ep_play" href="#">ACHETER</a>
                        <?php endif; ?>
                        
                    <?php endif; ?>
                    
                    </div>
                </div>
                
            <?php endforeach; ?>
            </div>
            
            <div class="ep_list">
                <ul>
                <?php foreach ($episodes as $episode): ?>
                    <?php if($current_ep == $episode): ?>
                    <li class="active"><?php echo '#'.$episode->episode; ?></li>
                    <?php else: ?>
                    <li><?php echo '#'.$episode->episode; ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    
</div>


<div id="simon" class="layer">
    <?php echo Asset::img('season13/illus/simonHD.png', array('alt' => 'Simon - SEASON 13')); ?>
</div>

<div class="center">
    <div id="access_dialog" class="dialog">
        <div class="close"></div>
        <h1></h1>
        <div class="sep_line"></div>
    </div>
</div>