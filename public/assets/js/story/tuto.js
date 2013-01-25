var tuto = (function(){
	var tuto = {}, exports = tuto;
	var state = 'START';

	var topPos = -50;  // box offset compare to the target obj
	var leftPos = 0;

	var outils,
		like,
		comment;

	var msgBox = $('<div id="tuto"></div>');
	msgBox.append($('<div></div>'));
	msgBox.append($('<img></img>'));

	var msgTextContainer = msgBox.children('div');
	var indic = msgBox.children('img');

	function init() {
		state = 'START';
		$('body').append(msgBox);
		indic.prop('src', config.base_url+'assets/img/season13/ui/indic_tuto.png');
	}
	$(init);

	function attachMessage(target, msg) {
		// tutoDiv.show();
		msgBox.show();
		msgTextContainer.html(msg);

		var msgBoxCenter = msgBox.width() / 2;
		var tarCenter = target.width() / 2;

		var tarPos = target.offset();

		var indicPos = tarCenter - indic.width()/2;
		indic.css('left', indicPos+'px');

		tarPos.top += topPos;
		tarPos.left += leftPos;
		msgBox.offset(tarPos);
	}

	exports.attachMessage = attachMessage;

	return exports;
})();