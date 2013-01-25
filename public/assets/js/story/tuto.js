$(document).ready(function() {
    
    window.tuto = new MseScenario();
    
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
                msgs[0].target = this.btn;
                msgs[0].message = "Boîte à outils";
                msgs[0].show();
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
                msgs[0].target = this.btn;
                msgs[0].message = "J'aime l'épisode, ou <a href='javascript:tuto.passNext();'>Saute cet étape</a>";
                msgs[0].show();
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
                msgs[0].target = this.btn;
                msgs[0].message = "Lecture plus rapide";
                msgs[0].show();
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
                
                // Message
                msgs[0].target = this.circle;
                msgs[0].message = "Ta vitesse de lecture";
                msgs[0].show();
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
                msgs[0].target = this.btn;
                msgs[0].message = "Lecture plus lente";
                msgs[0].show();
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
                'endDelay': 2000,
            },
            
            // Start
            function() {
                if(!gui.isToolsOpen())
                    gui.openhideTools();
            
                this.btn.click({'action': this}, endfunction);
                
                // Message
                msgs[0].target = this.btn;
                msgs[0].message = "Arrêter ou recommencer la lecture";
                msgs[0].show();
            },
            
            // End
            function() {
                this.btn.unbind('click', endfunction);
                if(mse) {
                    // Message
                    msgs[0].target = this.btn;
                    if(mse.root.inPause) 
                        msgs[0].message = "Lecture arrêtée";
                    else msgs[0].message = "Lecture recommencée";
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
                msgs[0].target = this.btn;
                msgs[0].message = "Laisse un commentaire pour tes amis";
                msgs[0].show();
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
                msgs[0].target = this.content;
                msgs[0].message = "Ton commentaire ici";
                msgs[0].show();
                msgs[1].target = this.comments;
                msgs[1].message = "Les commentaire des autres lecteurs";
                msgs[1].show();
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
                    
                    msgs[0].target = action.btn;
                    msgs[0].message = "Capture une image";
                    msgs[0].show();
                    
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
                msgs[0].target = this.root;
                msgs[0].message = "Capture une image en appuyant le bouton gauche du souris";
                msgs[0].show();
                
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
                    
                    msgs[0].target = action.confirmBn;
                    msgs[0].message = "Valide cette image";
                    msgs[0].show();
                    msgs[1].target = action.recapBn;
                    msgs[1].message = "Change d'image";
                    msgs[1].show();
                    msgs[2].target = action.editBn;
                    msgs[2].message = "Customise l'image";
                    msgs[2].show();
                    msgs[3].target = action.closeBn;
                    msgs[3].message = "Annuler la capture";
                    msgs[3].show();
                    
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
                    
                    msgs[0].target = action.btn;
                    msgs[0].message = "Partager sur Facebook ou uniquement sur le site";
                    msgs[0].show();
                    msgs[1].target = action.content;
                    msgs[1].message = "Tape ton commentaire";
                    msgs[1].show();
                    
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
                'beginDelay': 2000,
                'btn': gui.comment_menu.children('#btn_upload_img'),
                'endDelay': 3000,
            },
            
            // Start
            function() {
                gui.openComment();
                
                msgs[0].target = this.btn;
                msgs[0].message = "Tu peux aussi télécharger ton dessin";
                msgs[0].show();
                
                this.end();
            },
            
            // End
            function() {
                msgs[0].hide();
            }
        ),
    ];
    
    tuto.addActions(actions);
    
});


