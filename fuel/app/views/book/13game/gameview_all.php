<style type="text/css">
    #single_game_shower {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.78);
        display: none;
        z-index: 4;
    }
    #single_game_shower iframe {
        border: none;
        width: 100%;
        height: 100%;
    }
</style>


<div id="single_game_shower"><iframe src="about:blank"></iframe></div>
<div class="main_container">
    <?php foreach($games as $game): ?>
        <p class="game_link" data-gameId="<?php echo $game->id; ?>"><?php echo $game->name ?></p>
    <?php endforeach; ?>
</div>
