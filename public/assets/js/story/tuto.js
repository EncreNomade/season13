$(document).ready(function() {
    
    window.tuto = new MseScenario();
    
    var topMessage = null;
    
    window.quitTuto = function() {
        tuto.quit();
        if(topMessage) {
            msgCenter.closeMessage(topMessage);
            topMessage = null;
        }
    };
    
    var endfunction = function(e) {
        e.data.action.end();
    }
    
    var msgs = [
        new MseTutoMsg(null, ""),
        new MseTutoMsg(null, ""),
        new MseTutoMsg(null, ""),
        new MseTutoMsg(null, ""),
        new MseTutoMsg(null, ""),
    ];
    
    var actions = [
        new MseAction(
            'BtnMenu',
            
            {
                'btn': $('#switch_menu'),
                'endDelay': 600,
            },
            
            // Start
            function() {
                topMessage = msgCenter.send("Le tutoriel est lancé, suivre les indications, vous pouvez arrêter à tout moment en cliquant <a href='javascript:quitTuto();'>ici</a>", 0);
            
                if(gui.menu.hasClass('active')) {
                    this.end();
                    return;
                }
            
                $('#icon_menu, #sep_right, #switch_menu').click({'action': this}, endfunction);
                
                // Message
                msgs[0].reinit(this.btn, "Clique pour ouvrir le menu", {'position':'left'}).show();
            },
            
            // End
            function() {
                msgs[0].hide();
                $('#icon_menu, #sep_right, #switch_menu').unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'OpenParameters',
            
            {
                'btn': $('#btn_param'),
                'endDelay': 600,
            },
            
            // Start
            function() {
                this.btn.click({'action': this}, endfunction);
                
                // Message
                msgs[0].reinit(this.btn, "Clique pour configurer les paramètres", {'position':'left'}).show();
            },
            
            // End
            function() {
                msgs[0].hide();
                this.btn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'Parameters',
            
            {
                'audio': gui.audioctrl.jqObj,
                'speed': gui.speedctrl.jqObj,
                'fbComment': gui.pref.find('#share_comment_fb'),
                'close': gui.pref.children('.close'),
                'fbNotif': function() {
                    if($(this).prop('checked')) {
                        msgs[2].message = "Vos commentaires seront publiés sur Facebook aussi si votre compte Facebook est lié";
                    }
                    else {
                        msgs[2].message = "Vos commentaires seront publiés que sur Season13";
                    }
                },
                'endDelay': 600,
            },
            
            // Start
            function() {
                // Message
                msgs[0].reinit(this.audio, "Faire bouger pour changer la volume de son", {'position':'top'}).show();
                msgs[1].reinit(this.speed, "Faire bouger pour changer la vitesse de lecture", {'position':'right'}).show();
                msgs[2].reinit(this.fbComment, "Publication de vos commentaires sur Facebook", {'position':'bottom'}).show();
                msgs[3].reinit(this.close, "Fermer cette fenêtre", {'position':'top'}).show();
                
                this.close.click({'action': this}, endfunction);
                this.fbComment.change(this.fbNotif);
            },
            
            // End
            function() {
                msgs[0].hide();
                msgs[1].hide();
                msgs[2].hide();
                msgs[3].hide();
                this.fbComment.unbind('change', this.fbNotif);
                this.close.unbind('click', endfunction);
            }
        ),
        
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
                
                // Message
                msgs[0].reinit(this.btn, "Boîte à outils", {'position':'right'}).show();
            },
            
            // End
            function() {
                msgs[0].hide();
                this.btn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'Like',
            
            {
                'beginDelay': 500,
                'btn': gui.fblike,
                'endDelay': 600,
            },
            
            // Start
            function() {
                if(!gui.isToolsOpen())
                    gui.openhideTools();
                
                this.btn.click({'action': this}, endfunction);
                
                // Message
                msgs[0].reinit(this.btn, "J'aime l'épisode, ou <a href='javascript:tuto.passNext();'>Saute cet étape</a>").show();
            },
            
            // End
            function() {
                msgs[0].hide();
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
                
                // Message
                msgs[0].reinit(this.btn, "Lecture plus rapide").show();
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
                
                // Message
                msgs[0].reinit(this.circle, "Ta vitesse de lecture").show();
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
                
                // Message
                msgs[0].reinit(this.btn, "Lecture plus lente").show();
            },
            
            // End
            function() {
                msgs[0].hide();
                this.btn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'Playpause',
            
            {
                'btn': gui.playpause,
                'endDelay': 1200,
            },
            
            // Start
            function() {
                if(!gui.isToolsOpen())
                    gui.openhideTools();
            
                this.btn.click({'action': this}, endfunction);
                
                // Message
                msgs[0].reinit(this.btn, "Arrêter ou recommencer la lecture").show();
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
                if(mse) {
                    // Message
                    msgs[0].reinit(this.btn, "Lecture recommencée");
                    if(mse.root.inPause) 
                        msgs[0].message = "Lecture arrêtée";
                    msgs[0].show();
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
                
                // Message
                msgs[0].reinit(this.btn, "Laisse un commentaire pour tes amis").show();
            },
            
            // End
            function() {
                msgs[0].hide();
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
            
                this.content.click({'action': this}, endfunction);
                
                // Messages
                msgs[0].reinit(this.content, "Ton commentaire ici", {'position':'center'}).show();
                msgs[1].reinit(this.comments, "Les commentaire des autres lecteurs", {'position':'center'}).show();
            },
            
            // End
            function() {
                msgs[0].hide();
                msgs[1].hide();
                this.content.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'CommentMenu',
            
            {
                'menu': gui.comment_menu,
                'btn': gui.comment_menu.children('#btn_capture_img'),
                'showMsg': function(e) {
                    var action = e.data.action;
                    action.menu.children('li').unbind('mouseover', action.showMsg);
                    
                    msgs[0].reinit(action.btn, "Capture une image").show();
                    
                    action.btn.click({'action': action}, endfunction);
                },
                'endDelay': 600,
            },
            
            // Start
            function() {
                gui.openComment();
            
                this.menu.children('li').mouseover({'action': this}, this.showMsg);
            },
            
            // End
            function() {
                msgs[0].hide();
                this.btn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'ChooseZone',
            
            {
                'root': mse.root.jqObj,
                'endDelay': 600,
            },
            
            // Start
            function() {
                msgs[0].reinit(this.root, "Capture une image en appuyant le bouton gauche du souris", {'position':'center'}).show();
                
                this.end();
            }
        ),
        
        new MseAction(
            'CaptureDialog',
            
            {
                'scriber': gui.scriber.jq,
                'preventEvent': function(e) {
                    e.stopImmediatePropagation();
                },
                'showMsg': function(e) {
                    var action = e.data.action;
                    action.scriber.unbind('mouseover', this.showMsg);
                    
                    msgs[0].reinit(action.confirmBn, "Valide cette image", {'position':'right'}).show();
                    msgs[1].reinit(action.recapBn, "Change d'image", {'position':'bottom'}).show();
                    msgs[2].reinit(action.editBn, "Customise l'image", {'position':'top'}).show();
                    msgs[3].reinit(action.closeBn, "Annuler la capture", {'position':'bottom'}).show();
                    
                    action.confirmBn.click({'action': action}, endfunction);
                    action.recapBn.click({'action': action}, endfunction);
                    action.editBn.click({'action': action}, endfunction);
                    action.closeBn.click({'action': action}, endfunction);
                },
                'endDelay': 600,
            },
            
            // Start
            function() {
                this.confirmBn = this.scriber.find('#sb_confirm');
                this.recapBn = this.scriber.find('#sb_recap');
                this.editBn = this.scriber.find('#sb_edit');
                this.closeBn = this.scriber.children('.close');
                
                this.scriber.mouseover({'action': this}, this.showMsg);
            },
            
            // End
            function() {
                msgs[0].hide();
                msgs[1].hide();
                msgs[2].hide();
                msgs[3].hide();
                this.confirmBn.unbind('click', endfunction);
                this.recapBn.unbind('click', endfunction);
                this.editBn.unbind('click', endfunction);
                this.closeBn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'CommentSend',
            
            {
                'dialog': gui.comment,
                'content': gui.comment_content,
                'btn': gui.comment_share_btn,
                'showMsg': function(e) {
                    var action = e.data.action;
                    action.dialog.unbind('mouseover', action.showMsg);
                    
                    msgs[0].reinit(action.btn, "Partager sur Facebook ou uniquement sur le site").show();
                    msgs[1].reinit(action.content, "Tape ton commentaire", {'position':'center'}).show();
                    
                    action.btn.click({'action': action}, endfunction);
                },
                'endDelay': 600,
            },
            
            // Start
            function() {
                this.dialog.mouseover({'action': this}, this.showMsg);
            },
            
            // End
            function() {
                msgs[0].hide();
                msgs[1].hide();
                this.btn.unbind('click', endfunction);
            }
        ),
        
        new MseAction(
            'CommentUpload',
            
            {
                'beginDelay': 1200,
                'btn': gui.comment_menu.children('#btn_upload_img'),
                'endDelay': 600
            },
            
            // Start
            function() {
                gui.openComment();
                
                msgs[0].reinit(this.btn, "Tu peux aussi télécharger ton dessin").show();
                
                var action = this;
                setTimeout(function() {
                    action.end();
                }, 2500);
            },
            
            // End
            function() {
                msgs[0].hide();
            }
        ),
        
        new MseAction(
            'Finish',
            
            {},
            
            // Start
            function() {
                msgCenter.send("Le tutoriel est terminée, vous pouvez continuez votre histoire", 4000);
                window.quitTuto();
            }
        ),
    ];
    
    tuto.addActions(actions);
    
});


