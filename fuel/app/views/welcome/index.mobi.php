<header>
    <p>
        Saison 1
    </p>
</header>

<section id="episodes">
<?php foreach ($episodes as $ep): ?>

    <article class="expo" 
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
        <?php echo Html::img($ep->image); ?>
        
        <div class="cadre"></div>
        <a href="<?php echo '/'.$ep->getRelatLink(); ?>"></a>
        
    </article>
<?php endforeach; ?>

</section>