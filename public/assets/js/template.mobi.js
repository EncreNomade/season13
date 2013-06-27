(function () {

var _menuitems;
var _startx, _starty;

function init() {
    _menuitems = $('footer menu ul li');
    _menuitems.bind('touchstart', function(e) {
        var touch = e.originalEvent.targetTouches[0];
        _startx = touch.pageX;
        _starty = touch.pageY;
        $(this).addClass('holding');
    });
    _menuitems.bind('touchmove', function(e) {
        var touch = e.originalEvent.targetTouches[0];
        if(_startx > 0 && _starty > 0) {
            var dx = Math.abs(touch.pageX - _startx);
            var dy = Math.abs(touch.pageY - _starty);
            if(dx > 10 || dy > 10) {
                _startx = -1;
                _starty = -1;
                $(this).removeClass('holding');
            }
        }
    });
    _menuitems.bind('touchend', function(e) {
        if(_startx > 0 && _starty > 0) {
            $(this).siblings().andSelf().removeClass('holding').removeClass('active');
            $(this).addClass('active');
        }
    });
};

$(document).ready(init);

})();