$(function(){
	var gameShower = $('#single_game_shower');
	var iframe = gameShower.children('iframe');

	$(".game_link").click(function(){
		var gameId = $(this).attr('data-gameId');
		iframe.prop('src', config.base_url+'book/gameview/playGame/'+gameId);
		gameShower.show();
	});




	window.gameNotifier = {
		quit: function(){
			iframe.prop('src', 'about:blank');
			gameShower.hide();
		},
		failGameLoad: function(message) {
			gameNotifier.quit();
			alert(message);
		}
	};
});