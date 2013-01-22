
var GameInfo = (function() {
    var GameInfo = {}, exports = GameInfo;
    var lastRegistredGame;

    exports.register = function(game, className) {
        lastRegistredGame = game;
        game.evtDeleg.addListener( 'end', new Callback(saveScore, this, game, className) );
        getScore(game, className);
    };

    // public access to the game result
    // exports.__defineGetter__('result', function(){ return lastRegistredGame.result ; });

    function getScore(game, className) {
        $.ajax({
            url: config.base_url + 'user/data/gameInfo',
            type: 'GET',
            data: { 'className': className },
            dataType: 'json',
            success: function(gameInfo) {
                if(gameInfo.high_score)
                    game.setHighScore(gameInfo.high_score);
            },
            error: ajaxError
        });
    }

    function saveScore(game, className) {
        $.ajax({
            url: config.base_url + 'user/data/gameInfo',
            type: 'POST',
            data: {
                'className': className,
                'score': game.result.score
            },
            dataType: 'json',
            error: ajaxError
        });
    };


    function ajaxError(jqXhr) {
        if(config.readerMode != 'debug')
            return;
        var newWindow = window.open('_blank');
        newWindow.document.open();
        newWindow.document.write(jqXhr.responseText);
        newWindow.document.close();
    }

    return exports;
})();

