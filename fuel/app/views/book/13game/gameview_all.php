
<div class="main_container">
    <ul class="game_list">
    <?php foreach($games as $game): ?>
        <li>
        <!-- <p class="game_link" data-gameId="<?php //echo $game->id; ?>"><?php //echo $game->name ?></p> -->
            <h1><?php echo $game->name; ?></h1>
            <p>
                <strong>Episode : </strong>
                <?php echo Html::anchor($game->episode->getRelatLink(), $game->episode->title) ?>
            </p>
            <?php echo Asset::img($game->expo, array("class" => "expo")); ?>
            <p><?php echo $game->presentation; ?></p>
            <div>
                <?php echo Html::anchor("book/gameview/info/".$game->id, 'Infos'); ?>
            </div>
        </li>
    <?php endforeach; ?>

    </ul>
</div>
