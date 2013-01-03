<div id="episodes">

    <ul>
    <?php foreach ($episodes as $ep): ?>
        <li><a href="<?php echo $ep['link']; ?>">
    
            <?php echo Html::img($ep['obj']->image); ?>
            <h5><?php echo 'Episode'.$ep['obj']->episode.'  '.stripslashes($ep['obj']->title); ?></h5>
        
        </a></li>
    <?php endforeach; ?>
    </ul>
    
</div>