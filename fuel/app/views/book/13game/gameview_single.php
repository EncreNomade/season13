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
	<h1><?php echo $game->name; ?></h1>
	<?php if(is_null($current_user)): ?>
		<p>vous devez vous inscrire pour jouer</p>
	<?php else: ?>
		<button class="game_link" data-gameId="<?php echo $game->id; ?>">Jouer</button>
	<?php endif; ?>
</div>
