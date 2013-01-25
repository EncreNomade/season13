var tuto_msg = (function(){
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




$(document).ready(function() {
    
    window.tuto = new MseScenario();
    
    var endfunction = function(e) {
        e.data.action.end();
    }
    
    var actions = [
        new MseAction(
            'BtnTools',
            
            {
                'btn': gui.controler.children('#circle'),
            },
            
            // Start
            function() {
                if(gui.isToolsOpen())
                    gui.openhideTools();
            
                this.btn.click({'action': this}, endfunction);
                tuto_msg.attachMessage(this.btn, "Boîte à outils");
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'Like',
            
            {
                'btn': gui.fblike,
                'endDelay': 600,
            },
            
            // Start
            function() {
                if(!gui.isToolsOpen())
                    gui.openhideTools();
                
                var action = this;
                setTimeout(function() {
                    action.btn.click({'action': action}, endfunction);
                    tuto_msg.attachMessage(action.btn, "J'aime l'épisode, ou <a href='javascript:tuto.passNext();'>Saute cet étape</a>");
                }, 500)
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'Speedup',
            
            {
                'btn': gui.speedup,
                'circle': gui.controler.children('#circle'),
                'endDelay': 2000,
            },
            
            // Start
            function() {
                if(!gui.isToolsOpen())
                    gui.openhideTools();
            
                this.btn.click({'action': this}, endfunction);
                tuto_msg.attachMessage(this.btn, "Lecture plus rapide");
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
                tuto_msg.attachMessage(this.circle, "Ta vitesse de lecture");
            }
        ),
        
        new MseAction(
            'Slowdown',
            
            {
                'btn': gui.slowdown,
                'endDelay': 600,
            },
            
            // Start
            function() {
                if(!gui.isToolsOpen())
                    gui.openhideTools();
            
                this.btn.click({'action': this}, endfunction);
                tuto_msg.attachMessage(this.btn, "Lecture plus lente");
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'Playpause',
            
            {
                'btn': gui.playpause,
                'endDelay': 2000,
            },
            
            // Start
            function() {
                if(!gui.isToolsOpen())
                    gui.openhideTools();
            
                this.btn.click({'action': this}, endfunction);
                tuto_msg.attachMessage(this.btn, "Arrêter ou recommencer la lecture");
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
                if(mse) {
                    if(mse.root.inPause) 
                        tuto_msg.attachMessage(this.btn, "Lecture arrêtée");
                    else tuto_msg.attachMessage(this.btn, "Lecture recommencée");
                }
            }
        ),
        
        new MseAction(
            'Comment',
            
            {
                'btn': gui.commentbtn,
                'endDelay': 600,
            },
            
            // Start
            function() {
                if(!gui.isToolsOpen())
                    gui.openhideTools();
            
                this.btn.click({'action': this}, endfunction);
                tuto_msg.attachMessage(this.btn, "Laisse un commentaire pour tes amis");
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'CommentDialog',
            
            {
                'content': gui.comment_content,
                'comments': gui.userComments,
                'endDelay': 600,
            },
            
            // Start
            function() {
                gui.openComment();
            
                this.btn.click({'action': this}, endfunction);
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
            }
        ),
    ];
    
    tuto.addActions(actions);
    
});


